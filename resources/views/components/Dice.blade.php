			/*******************************************************************
			 * Dice functionality inserted from views/componets/Dice.blade.php *
			 *******************************************************************/

			var el = document.createElement("input");
			el.style = "position: absolute; top: 930px; left: 1725px; width: 160px; color: yellow; background-color: blue; border-radius: 5px;";
			el.type = "text";
			el.id = "Roll";
			el.addEventListener("change",function(e) {onChange(e);});
			document.body.appendChild(el);
			
			function onChange(e)
			{
				var character = {"DEX": 3, "STR": 5};
				var specs = document.getElementById("Roll").value;
				document.getElementById("Roll").value = "";
				notify(player+" Rolled "+roll(specs, character),10000);
			}

			function roll(specs, info)
			{				
				specs = specs.toUpperCase();
				var calc = specs;
				if(info!=undefined)
				{
					result = resolveAttributes(specs,info);
					specs = result[0];
					calc = result[1];
				}
				var result = resolveDice(specs,calc);
				specs = result[0];
				calc = result[1];
				return specs.toUpperCase() + " = " + eval(calc);
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
						specs = specs.replace(attrib,attribText.toLowerCase()+info[attribText]);
						calc = calc.replace(attrib,info[attribText]);
					}
					else
					{
						specs = specs.replace(attrib,attrinText.toLowerCase()+"0");
						calc = calc.replace(attrib,0);
					}						
				}
				return [specs, calc];
			}
			
			function resolveDice(specs, calc)
			{
				while(specs.indexOf("D")>-1)
				{
					var pos = specs.indexOf("D");
					var prefix = pos-1;
					while(prefix>0 && "0123456789".indexOf(specs.substring(prefix,prefix+1))>-1) { prefix--; }
					var num_dice = specs.substring(prefix,pos);
					var num_dice_int = parseInt(num_dice);
					if(isNaN(num_dice_int)){num_dice_int=1;}
					var suffix = pos+1;
					while(suffix<specs.length && "0123456789".indexOf(specs.substring(suffix,suffix+1))>-1) { suffix++; }
					var dice_sides = specs.substring(pos+1,suffix);
					var desc = num_dice+"_"+dice_sides+"{";
					for(var dice=0; dice<Math.max(num_dice_int,1); dice++)
					{
						var roll = parseInt(Math.random() * parseInt(dice_sides)) + 1;
						desc = desc + roll;
						if(dice<(num_dice-1)){desc=desc+"+";}
					}
					calc = calc.replace(num_dice+"D"+dice_sides,desc.substr(desc.indexOf("{")+1));	
					desc = desc +"}";					
					specs = specs.replace(num_dice+"D"+dice_sides,desc);
				}
				while(specs.indexOf("_")>-1){specs = specs.replace("_","D");}
				return [specs, calc];
			}
						