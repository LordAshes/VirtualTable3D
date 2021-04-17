
			/*********************************************************************
			 * Mouse functionality inserted from views/componets/Mouse.blade.php *
			 *********************************************************************/

			var selected = null;

			var lastMouse = {x: 0, y:0};

			function onMouseDown(e)
			{
				modeCheck();
				clearInterval(pulse);
			}
			
			function onMouseMove(e)
			{
				var dX = e.clientX - lastMouse.x;
				var dY = e.clientY - lastMouse.y;
				lastMouse.x = e.clientX;
				lastMouse.y = e.clientY;
				onMouseProcess(state, dX, dY);
			}
			
			function onMouseProcess(operation, dX, dY)
			{
				if(alt && operation == STATE.WORLD_TILT) {operation = STATE.WORLD_LIFT; }
				if(!alt && operation == STATE.WORLD_LIFT) {operation = STATE.WORLD_TILT; }
			
				switch(operation)
				{
					case STATE.WORLD_MOVE:
						// Adjust mouse X/Y by the view angle to correct direction when not viewed from the front
						var mX = dX*speedMove*Math.cos(angle*Math.PI/180)-dY*speedMove*Math.sin(angle*Math.PI/180);
						var mY = dY*speedMove*Math.cos(angle*Math.PI/180)+dX*speedMove*Math.sin(angle*Math.PI/180);
						camera.position.add(new THREE.Vector3(-1*mX,0,-1*mY));
						break;
					case STATE.WORLD_LIFT:
						camera.position.add(new THREE.Vector3(0,dY*speedMove,0));
						break;						
					case STATE.WORLD_TILT:
						if(dY!=0)
						{
							dY = (dY/Math.abs(dY)*speedRotate*10);
							tilt = tilt + (dY*Math.PI/180);
							if(tilt<-89){tilt = -89;}
							if(tilt>-5){tilt = -5;}
						}
						break;
					case STATE.WORLD_ROTATE:
						if(dX!=0)
						{
							dX = (dX/Math.abs(dX)*speedRotate*10);
							angle = angle + (-1*dX*Math.PI/180);
						}
						break;
					case STATE.OBJ_MOVE:
						// Adjust mouse X/Y by the view angle to correct direction when not viewed from the front
						var mX = dX*speedMove*Math.cos(angle*Math.PI/180)-dY*speedMove*Math.sin(angle*Math.PI/180);
						var mY = dY*speedMove*Math.cos(angle*Math.PI/180)+dX*speedMove*Math.sin(angle*Math.PI/180);
						// Apply position modification to selected object
						scene.children[selected].position.add(new THREE.Vector3(mX,0,mY));
						// Object updated on server on object drop to minimize server load
						break;
					case STATE.OBJ_ROTATE:
						// Ensure angle is cycles between -360 and 360
					    if(dX<0){dX = -1*speedRotate;}else{dX = speedRotate;}
						if(objectInfo[scene.children[selected].name].facing==undefined){objectInfo[scene.children[selected].name].facing=0;}
						objectInfo[scene.children[selected].name].facing = objectInfo[scene.children[selected].name].facing + dX;
						if(objectInfo[scene.children[selected].name].facing<-180){objectInfo[scene.children[selected].name].facing=objectInfo[scene.children[selected].name].facing+360;}
						if(objectInfo[scene.children[selected].name].facing>180){objectInfo[scene.children[selected].name].facing=objectInfo[scene.children[selected].name].facing-360;}
						// Apply rotation modification to selected object
						scene.children[selected].rotation.y = -1*objectInfo[scene.children[selected].name].facing*Math.PI/180;
						// Object updated on server on object drop to minimize server load
						break;
					case STATE.OBJ_LIFT:
						scene.children[selected].position.add(new THREE.Vector3(0,dY*-1*speedLift,0));
						break;
					case STATE.ZOOM:
					case STATE.NONE:
					default:
						break;
				}
			}

			function onMouseUp(e)
			{
				try
				{
					if(objectInfo[scene.children[selected].name].facing==undefined){objectInfo[scene.children[selected].name].facing=0;}
					var update = "scene.children["+selected+"].position.set("+scene.children[selected].position.x+","+scene.children[selected].position.y+","+scene.children[selected].position.z+");\r\n"
							   + "scene.children["+selected+"].rotation.set("+scene.children[selected].rotation.x+","+scene.children[selected].rotation.y+","+scene.children[selected].rotation.z+");\r\n"
							   + "objectInfo[scene.children["+selected+"].name].facing="+objectInfo[scene.children[selected].name].facing+";\r\n"
				}
				catch(e){;}
				selected = null;
				state = STATE.NONE;
				clearInterval(pulse);
				pulse = setInterval(function() { updateGet(updateCallback); },1000);
				updateSend(update,csrf);
			}

			function onMouseScroll(e)
			{
				
				if(e.deltaY>0)
				{
					zoom = zoom * (1+(e.deltaY/2000));
				}
				else
				{
					zoom = zoom / (1+(Math.abs(e.deltaY)/2000));
				}
			}
			
			function modeCheck()
			{
				var mouse3D = new THREE.Vector3( ( event.clientX / window.innerWidth ) * 2 - 1, -( event.clientY / window.innerHeight ) * 2 + 1, 0.5 );     
				var raycaster =  new THREE.Raycaster();                                        
				raycaster.setFromCamera( mouse3D, camera );				
				var intersects = raycaster.intersectObjects( scene.children, true );
				selected = null;
				if(intersects.length>0)
				{
					for(var o=0; o<intersects.length; o++)
					{
						var intersetObj = findParent(intersects[o].object).name;
						console.log(findParent(intersects[o].object));
						if(((objectInfo[intersetObj].type!="Fixed") && (objectInfo[intersetObj].layer==layer)) || shift==true)
						{
							selected = findChildId(intersetObj); 
							if(event.button==0)
							{
								state = STATE.OBJ_MOVE;
							}
							else if(event.button==1)
							{
								state = STATE.OBJ_ROTATE;
							}
							else if(event.button==2)
							{
								state = STATE.OBJ_LIFT;
							}
							break;
						}
					}
				}
				if(selected==null)
				{
					if(event.button==0)
					{
						state = STATE.WORLD_MOVE;
					}
					else if(event.button==1)
					{
						state = STATE.WORLD_ROTATE;
					}
					else if(event.button==2)
					{
						state = STATE.WORLD_TILT;
					}
				}
			}
			
			function intersects(cube1, cube2)
			{
				var c1p = cube1.position;
				var c1b = objectInfo[cube1.name].bounds;
				var c2p = cube2.position;
				var c2b = objectInfo[cube2.name].bounds;

				// alert(cube1.name+" vs "+cube2.name);
				
				// Cube 1 is to the left of Cube 2
				if((c1p.x+c1b.x+c1b.w) < (c2p.x+c2b.x)) { return 1; }
				// Cube 2 is to the left of Cube 1
				if((c2p.x+c2b.x+c2b.w) < (c1p.x+c1b.x)) { return 2; }			
				// Cube 1 is to the top of Cube 2
				if((c1p.y+c1b.y+c1b.h) < (c2p.y+c2b.y)) { return 3; }
				// Cube 2 is to the top of Cube 1
				if((c2p.y+c2b.y+c2b.h) < (c1p.y+c1b.y)) { return 4; }			
				// Cube 1 is in front of Cube 2
				if((c1p.z+c1b.z+c1b.d) < (c2p.z+c2b.z)) { return 5; }
				// Cube 2 is in front of Cube 1
				if((c2p.z+c2b.z+c2b.d) < (c1p.z+c1b.z)) { return 6; }			
				// Otherwise there must me an intersection
				return 0;
			}
