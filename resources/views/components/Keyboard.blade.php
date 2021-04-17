			/***************************************************************************
			 * Keyboard functionality inserted from views/componets/Keyboard.blade.php *
			 ***************************************************************************/

  			var alt = 0;
			var ctrl = 0;
			var shift = 0;
			
			var layer = "Token";
			
			var phase = true;
			 
			function onKeyDown(e)
			{
				// console.log(e.code);
				if(e.altKey){alt=true;}else{alt=false;}
				if(e.ctrlKey){ctrl=true;}else{ctrl=false;}
				if(e.shiftKey){shift=true;}else{shift=false;}
				if((e.code.substring(0,5)=="Digit")&&(!gm)){return;}
				
				if(ctrl)
				{
					notify("World: 1=Switch To Token Layer, 2=Switch To GM Layer / Object: 1=Move To Token Layer, 2=Move To GM Layer, F=Togge Free/Fixed");
				}
				
				switch(e.code)
				{
					case "BracketLeft":
						// Token Layer
						if(selected==null)
						{
							layer = "Token";
						}
						else
						{
							setOpacity(scene.children[selected],1.0);
							objectInfo[scene.children[selected].name].layer = "Token";
							updateSend("// Move '"+scene.children[selected].name+"' To 'Token' Layer\r\n"
									 + "setOpacity(scene.children['"+selected+"'],1.0);\r\n"
									 + "objectInfo['"+scene.children[selected].name+"'].layer='Token';\r\n", csrf);
							notify("Set Object '"+scene.children[selected].name+"' To 'Token' Layer");
						}
						break;
					case "BracketRight":
						// GM Layer
						if(selected==null)
						{
							layer = "GM";
						}
						else
						{
							if(gm){setOpacity(scene.children[selected],0.5);}else{setOpacity(scene.children[selected],0.0)}
							objectInfo[scene.children[selected].name].layer = "GM";
							updateSend("// Move '"+scene.children[selected].name+"' To 'GM' Layer\r\n"
									 + "if(gm){setOpacity(scene.children['"+selected+"'],0.5);}else{setOpacity(scene.children['"+selected+"'],0.0);}\r\n"
									 + "objectInfo['"+scene.children[selected].name+"'].layer='GM';\r\n", csrf);
							notify("Set Object '"+scene.children[selected].name+"' To 'GM' Layer");
						}
						break;
					case "KeyF":
						// Fixed / Free
						if(objectInfo[scene.children[selected].name].type.indexOf("Fixed")>=0)
						{
							objectInfo[scene.children[selected].name].type=objectInfo[scene.children[selected].name].type.replace("Fixed","Free");
						}
						else
						{
							objectInfo[scene.children[selected].name].type=objectInfo[scene.children[selected].name].type.replace("Free","Fixed");
						}
						updateSend("objectInfo['"+scene.children[selected].name+"'].type='"+objectInfo[scene.children[selected].name].type+"'", csrf);
						notify("Set Object '"+scene.children[selected].name+"' Set To '"+objectInfo[scene.children[selected].name].type+"'");
						selected = null;
						state = STATE.NONE;		
						break;
					case "Space":
						// Toggle Decroative Objects
						phase=!phase;
						scene.children.forEach(function (el)
						{
							if(objectInfo[el.name].decoration==true)
							{
								el.visible = phase;
							}
						});
						break;
					case "Numpad7":
						// View: Back Left
						camera.position.set(-5.5,1,-5.5);
						angle = 135;
						tilt = -12.5;
						zoom = 1;
						break;
					case "Numpad8":
						// View: Back
						camera.position.set(0,2,-8);
						angle = 180;
						tilt = -12.5;
						zoom = 1;
						break;
					case "Numpad9":
						// View: Back Right
						camera.position.set(5.5,1,-5.5);
						angle = 225;
						tilt = -12.5;
						zoom = 1;
						break;
					case "Numpad4":
						// View: Left
						camera.position.set(-8,2,0);
						angle = 90;
						tilt = -12.5;
						zoom = 1;
						break;
					case "Numpad5":
						// View: Top
						camera.position.set(0,8.5,0.25);
						angle = 0;
						tilt = -89;
						zoom = 1;
						break;
					case "Numpad6":
						// View: Right
						camera.position.set(8,2,0);
						angle = 270;
						tilt = -12.5;
						zoom = 1;
						break;
					case "Numpad1":
						// View: Front Left
						camera.position.set(-5.5,1,5.5);
						angle = 45;
						tilt = -12.5;
						zoom = 1;
						break;
					case "Numpad2":
						// View: Front
						camera.position.set(0,1,8);
						angle = 0;
						tilt = -5;
						zoom = 1;
						break;
					case "Numpad3":
						// View: Front Right
						camera.position.set(5.5,1,5.5);
						angle = 315;
						tilt = -12.5;
						zoom = 1;
						break;
					case "Numpad0":
						// View: Front Tilt
						camera.position.set(0,1.25,7);
						angle = 0;
						tilt = -12.5;
						zoom = 1;
						break;
					case "NumpadDecimal":
						// View: Front Tilt
						camera.position.set(0,3,7);
						angle = 0;
						tilt = -35;
						zoom = 1;
						break;					
					case "NumpadEnter":
					case "NumpadAdd":
						// View: Over-The-Shoulder View And Forward View
						if(selected!=null)
						{
							if(objectInfo[scene.children[selected].name].facing==undefined){objectInfo[scene.children[selected].name].facing=0;}
							angle = (objectInfo[scene.children[selected].name].facing+180);
							tilt = -20;
							var bounds = objectInfo[scene.children[selected].name].bounds;
												
							camera.position.set(scene.children[selected].position.x,scene.children[selected].position.y,scene.children[selected].position.z);
							
							var offset;
							if(e.code=="NumpadEnter") { offset = new THREE.Vector3(0.1,bounds.y+bounds.h,0.5); } else { offset = new THREE.Vector3(0,bounds.y+bounds.h,-0.2); }
							offset.applyAxisAngle(new THREE.Vector3(0,1,0),-1*angle*Math.PI/180);
							camera.position.add(offset);

							zoom = 1;
														
							selected = null;
							state = STATE.NONE;
						}
						break;
				}
			}
			
			function onKeyUp(e)
			{
				if(e.altKey){alt=true;}else{alt=false;}
				if(e.ctrlKey){ctrl=true;}else{ctrl=false;}
				if(e.shiftKey){shift=true;}else{shift=false;}
			}
