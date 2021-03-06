			/*******************************************************************
			 * Dice functionality inserted from views/componets/Dice.blade.php *
			 *******************************************************************/

			var el = document.createElement("input");
			el.style = "position: absolute; top: 930px; left: 1725px; width: 160px; color: yellow; background-color: blue; border-radius: 5px;";
			el.type = "text";
			el.id = "Roll";
			el.addEventListener("change",function(e) {onRollChange(e);});
			document.body.appendChild(el);
			
			function onRollChange(e)
			{
				var specs = document.getElementById("Roll").value;
				document.getElementById("Roll").value = "";
				
				onRollExecute(specs, specs)
			}
			
			function onRollExecute(specs,skill)
			{
				if(document.getElementById("Adv").checked==true){while(specs.indexOf("Nor(")>=0){specs = specs.replace("Nor(","Adv(");}}
				if(document.getElementById("Dis").checked==true){while(specs.indexOf("Nor(")>=0){specs = specs.replace("Nor(","Dis(");}}
								
				var max = 28;
				var rep = (max-(("("+player+")").length))/2;
				
				var header = "";
				var content = "";
				var footer = "";
				var pattern = "";
				for(var i=0; i<max; i++){header=header+"-"; pattern=pattern+" ";}
				footer = header;
				header = "<span style='color: #4D7896'>&boxdr;"+header.substring(0,rep)+"("+player+")"+header.substring(rep + ("|"+player+"|").length)+"&boxdl;</span>";
				footer = "<span style='color: #4D7896'>&boxur;"+footer+"&boxul;</span>";
				while(footer.indexOf("-")>-1){footer = footer.replace("-","&boxh;"); header = header.replace("-","&boxh;");}
				
				notify(footer,footer);
				var specParts = specs.split("|");
				for(var p=specParts.length-1; p>=0; p--)
				{
					content = roll(specParts[p], character);
					var short = content.replace(/<[^>]*>/g, '').replace("&nbsp;"," ").replace("&nbsp"," ");
					short = short.substring(short.lastIndexOf("=")+1).trim();
					if(short.indexOf(":")>-1)
					{
						short = short.replace(":"," =");
					}
					else
					{
						short = skill + " = " + short;
					}
					while(short.length<max){short = " "+short+" ";}
					short = short.substring(0,max);
					while(short.indexOf(" ")>-1){short = short.replace(" ","&nbsp");}
					short = "<span style='color: #4D7896'>&boxv;</span>"+short+"<span style='color: #4D7896'>&boxv;</span>";
					notify(short,content);
				}
				notify(header,header);				
			}

			function roll(specs, info)
			{				
				var calc = specs;
				specs = resolveText(specs);
				specs = resolveAdvAndDis(specs);
				if(info!=undefined)
				{
					specs = resolveAttributes(specs,info);
				}
				specs = resolveDice(specs);
				var calc = specs.replace(/<[^>]*>/g, '');
				while(calc.indexOf("[")>-1)
				{
					calc = calc.replace("[","(");
					calc = calc.replace("]",")");
				}
				while(specs.indexOf("<!-- ")>-1)
				{
					specs = specs.replace("<!-- ","");
					specs = specs.replace(" -->","");
				}
				while(specs.indexOf("Math.")>-1)
				{
					specs = specs.replace("Math.max","Adv");
					specs = specs.replace("Math.min","Dis");
				}
				return specs.toPascalCase() + " = " + "<SPAN class='Normal'>"+eval(calc)+"</SPAN>&nbsp";
			}
			
			function resolveText(specs)
			{
				var result = "";
				var escaped = false;
				for(var i=0; i<specs.length; i++)
				{
					if(specs.substring(i,i+1)!="D" || escaped)
					{
						result = result + specs.substring(i,i+1);
						if(specs.substring(i,i+1)=="'")
						{
							escaped = !escaped;
						}
						else if(specs.substring(i,i+1)=="{")
						{
							escaped = true;
						}
						else if(specs.substring(i,i+1)=="}")
						{
							escaped = false;
						}								
					}
					else
					{
						result = result + "~";
					}
				}
				return result;
			}
			
			function resolveAdvAndDis(specs)
			{
				while(specs.indexOf("Nor(")>-1)
				{
					specs = specs.replace("Nor(","(");
				}
				while(specs.indexOf("Adv(")>-1)
				{
					var roll = specs.substring(specs.indexOf("Adv(")+4);
					roll = roll.substring(0,roll.indexOf(")"));
					var fix = "ADV("+roll+","+roll+")";
					specs = specs.replace("Adv("+roll+")",fix);
				}
				while(specs.indexOf("Dis(")>-1)
				{
					var roll = specs.substring(specs.indexOf("Dis(")+4);
					roll = roll.substring(0,roll.indexOf(")"));
					var fix = "DIS("+roll+","+roll+")";
					specs = specs.replace("Dis("+roll+")",fix);
				}
				while(specs.indexOf("ADV(")>-1){specs=specs.replace("ADV(","Math.max(");}
				while(specs.indexOf("DIS(")>-1){specs=specs.replace("DIS(","Math.min(");}
				return specs;
			}
			
			function resolveAttributes(specs, info)
			{
				var calc = specs;
				while(specs.indexOf("{")>-1)
				{
					var attrib = specs.substring(specs.indexOf("{"),specs.indexOf("}")+1);
					var attribText = attrib.substring(1,attrib.length-1);
					if(info[attribText]!=undefined)
					{
						specs = specs.replace(attrib,"<!-- "+attribText.toLowerCase()+" -->[<SPAN class='Normal'>"+info[attribText]+"</SPAN>]");
					}
					else
					{
						specs = specs.replace(attrib,"<!-- "+attribText.toLowerCase()+" -->[<SPAN class='Failure'>0</SPAN>]");
					}						
				}
				return specs;
			}
			
			function resolveDice(specs)
			{
				while(specs.indexOf("~")>-1)
				{
					var pos = specs.indexOf("~");
					var prefix = pos-1;
					while(prefix>-1 && "0123456789".indexOf(specs.substring(prefix,prefix+1))>-1) { prefix--; }
					prefix++;
					var num_dice = specs.substring(prefix,pos);
					var num_dice_int = parseInt(num_dice);
					if(isNaN(num_dice_int)){num_dice_int=1;}
					var suffix = pos+1;
					while(suffix<specs.length && "0123456789".indexOf(specs.substring(suffix,suffix+1))>-1) { suffix++; }
					var dice_sides = specs.substring(pos+1,suffix);
					var desc = "<!-- "+num_dice+"D"+dice_sides+" -->[";
					for(var dice=0; dice<Math.max(num_dice_int,1); dice++)
					{
						var roll = parseInt(Math.random() * parseInt(dice_sides)) + 1;
						if(roll==1)
						{
							desc = desc + "<SPAN class='Failure'>"+roll+"</SPAN>";
						}
						else if (roll==dice_sides)
						{
							desc = desc + "<SPAN class='Success'>"+roll+"</SPAN>";
						}
						else
						{
							desc = desc + "<span class='Normal'>"+roll+"</span>";
						}
						if(dice<(num_dice-1)){desc=desc+"+";}else{desc=desc+"]";}
					}
					specs = specs.replace(num_dice+"~"+dice_sides,desc);
				}
				// while(specs.indexOf("_")>-1){specs = specs.replace("_","D");}
				return specs;
			}
			