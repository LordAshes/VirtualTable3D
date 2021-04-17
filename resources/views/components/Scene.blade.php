			/*********************************************************************
			 * 3D scene functionality inserted from views/componets/3D.blade.php *
			 *********************************************************************/

			import * as THREE from 'https://unpkg.com/three@0.126.1/build/three.module.js';

			import { GLTFLoader } from 'https://unpkg.com/three@0.126.1/examples/jsm/loaders/GLTFLoader.js';
			

			var camera, scene, renderer;
			
			var eye = new THREE.Vector3(0,2,9);

			// env map

			var path = "resources/images/";
			var format = '.jpg';
			var urls = 
			[
				path + 'px' + format, path + 'nx' + format,
				path + 'py' + format, path + 'ny' + format,
				path + 'pz' + format, path + 'nz' + format
			];

			var reflectionCube = new THREE.CubeTextureLoader().load( urls );
			
			const loader = new GLTFLoader();
			var mesh;

			init();
			animate();
			 
			function init() 
			{
				objectInfo = [];

				var aspect = window.innerWidth / window.innerHeight;

				camera = new THREE.PerspectiveCamera( 60, aspect, 0.1, 1000 );

				// world
				scene = new THREE.Scene();
				scene.background = new THREE.Color( 0xDDDDDD );
				scene.fog = new THREE.FogExp2( 0xcccccc, 0.002 );
				
				// Make a request to read configuration file
				var xhttp = new XMLHttpRequest();
				xhttp.open("GET", "resources/modules/"+module+".txt", true);
				xhttp.onreadystatechange = function()
				{
					if (this.readyState == 4 && this.status == 200)
					{
						if(xhttp.responseText.indexOf("\r\n")>=0)
						{
							// Process configuration file
							var backgroundColor = xhttp.responseText.substring(0,xhttp.responseText.indexOf("\r\n"));
							var content = xhttp.responseText.substring(xhttp.responseText.indexOf("\r\n")+2);
							var bkColor = new THREE.Color();
							bkColor.set("#"+backgroundColor);
							scene.background = bkColor;
							loadModels(content);
						}
					}
				};
				// Send request
				xhttp.send();

				// lights

				var light = new THREE.AmbientLight( 0xFFFFFF );
				light.name = "Light1";
				objectInfo[light.name] = {type: "Fixed", bounds: {x: 0, w: 0, y: -10, h:0, z: 0, d: 0} };
				scene.add( light );

				// renderer
				renderer = new THREE.WebGLRenderer( { antialias: true } );
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth-19, window.innerHeight-20);
				document.body.appendChild( renderer.domElement );
				
				// events
				document.body.addEventListener("mousedown",function(e) {onMouseDown(e);});
				document.body.addEventListener("mousemove",function(e) {onMouseMove(e);});
				document.body.addEventListener("mouseup",function(e) {onMouseUp(e);});
				document.body.addEventListener("wheel",function(e) {onMouseScroll(e);});
				document.body.addEventListener("keydown",function(e) {onKeyDown(e);});
				document.body.addEventListener("keyup",function(e) {onKeyUp(e);});
				
				// default viewport
				onMouseProcess(STATE.WORLD_ROTATE, 0, 0);
				
				// default view
				camera.position.set(0,3,7);
				angle = 0;
				tilt = -35;
				zoom = 1;
			}
						
			function loadModels(content)
			{
				var obj = content.substring(0,content.indexOf("\r\n"));
				content = content.substring(content.indexOf("\r\n")+2);
				var src = content.substring(0,content.indexOf("\r\n"));
				content = content.substring(content.indexOf("\r\n")+2);
				var pos = content.substring(0,content.indexOf("\r\n"));
				content = content.substring(content.indexOf("\r\n")+2);
				var specs = content.substring(0,content.indexOf("\r\n"));
				content = content.substring(content.indexOf("\r\n")+2);

				if(src!="{Clone}")
				{
					console.log("Mesh Load: "+obj+" ("+src+")");
					loader.load( "resources\\"+src, function ( gltf )
					{ 
						mesh = gltf.scene;
						mesh.name = obj;
						try
						{
							objectInfo[obj] = JSON.parse(specs);
							if(objectInfo[obj].scale==undefined){objectInfo[obj].scale=1.0;}
							if(objectInfo[obj].decoration==undefined){objectInfo[obj].decoration=false;}
						}
						catch(e)
						{
							console.log("Error Parsing ObjectInfo For '"+obj+"'");
						}
						var position = JSON.parse(pos);
						mesh.position.set(position.x,position.y,position.z);
						mesh.scale.set(objectInfo[obj].scale,objectInfo[obj].scale,objectInfo[obj].scale);
										
						if(specs.indexOf("GM")<0)
						{
							setOpacity(mesh,1.0);
						}
						else if(gm)
						{ 
							setOpacity(mesh,0.5);
						} 
						else
						{ 
							setOpacity(mesh,0.0);
						}
					
						scene.add( mesh );
						if(content!=""){loadModels(content);}
					},  undefined, function ( error ) { console.error( error ); } );
				}
				else
				{
					console.log("Mesh Clone: "+obj+" ("+pos+")");
					var clone = mesh.clone();
					clone.name = obj;
					try
					{
						objectInfo[obj] = JSON.parse(specs);
						if(objectInfo[obj].scale==undefined){objectInfo[obj].scale=1.0;}
						if(objectInfo[obj].decoration==undefined){objectInfo[obj].decoration=false;}
					}
					catch(e)
					{
						console.log("Error Parsing ObjectInfo For '"+obj+"' ("+e+")");
					}
					var position = JSON.parse(pos);
					clone.position.set(position.x,position.y,position.z);
					clone.scale.set(objectInfo[obj].scale,objectInfo[obj].scale,objectInfo[obj].scale);
					
					if(specs.indexOf("GM")<0)
					{
						setOpacity(mesh,1.0);
					}
					else if(gm)
					{ 
						setOpacity(mesh,0.5);
					} 
					else
					{ 
						setOpacity(mesh,0.0);
					}
					
					scene.add( clone );
					if(content!=""){loadModels(content);}
				}
			}
			
			function setOpacity(object, setting)
			{
				if(object.material!=undefined)
				{
					object.material.transparent = true;
					object.material.opacity = setting;
					object.material.envMap = reflectionCube;
					object.material.envMapIntensity = 0.9;
				}
				if(object.children!=undefined)
				{
					object.children.forEach(function (el)
					{
						setOpacity(el, setting);
					});
				}
			}
			
			function gravity()
			{
				var table = null;
				scene.children.forEach(function (faller)
				{
					if(objectInfo[faller.name].type != "Fixed")
					{
						var free = true;
						for(var blocker=0; blocker<scene.children.length; blocker++)
						{
							if(faller.id!=scene.children[blocker].id)
							{
								var check = intersects(faller, scene.children[blocker]);
								if(check==0){ free=false; break; } 
							}
						}
						if(free)
						{
							if(selected==null)
							{
								faller.position.add(new THREE.Vector3(0,-0.1,0));
							}
							else if(faller.name!=scene.children[selected].name)
							{
								faller.position.add(new THREE.Vector3(0,-0.1,0));							
							}
						}
					}
				});
			}
			
			function animate()
			{
			
				requestAnimationFrame( animate );
				gravity();
				
				var radAngle = angle/180*Math.PI;
				var radTilt = tilt/180*Math.PI;
				
				var cameraTarget = new THREE.Vector3(Math.sin(radAngle) + camera.position.x, Math.sin(radTilt) + camera.position.y, -1*Math.cos(radAngle)*Math.cos(radTilt) + camera.position.z);
				camera.lookAt(cameraTarget.x,cameraTarget.y,cameraTarget.z);
				camera.zoom = zoom;
				camera.updateProjectionMatrix();

				renderer.render( scene, camera);

				if(selected!=null)
				{
					document.getElementById("GuiInfo").innerHTML = "Player: "+player+", Layer: "+layer+", Object: "+scene.children[selected].name+", Rotation: "+objectInfo[scene.children[selected].name].facing+", Transaction: "+lastTransaction;
				}
				else
				{
					document.getElementById("GuiInfo").innerHTML = "Player: "+player+", Layer: "+layer+", Object: None, Tilt: "+tilt.toFixed(2)+", Angle: "+angle.toFixed(2)+", Transaction: "+lastTransaction; // +", Camera: "+camera.position.x+","+camera.position.y+","+camera.position.z+", LookAt: "+cameraTarget.x+","+cameraTarget.y+","+cameraTarget.z;
				}
			}
			
			function findParent(obj)
			{
				while((obj.parent!=null)&&(obj.parent!=scene))
				{
					obj = obj.parent;
				}
				return obj;
			}
			
			function findChildId(objName)
			{
				for(var c=0; c<scene.children.length; c++)
				{
					if(scene.children[c].name==objName)
					{
						return c;
					}
				}
				return -1;
			}
