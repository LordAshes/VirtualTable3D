			/*****************************************************************************************
			 * Character Sheet functionality inserted from views/componets/CharacterSheets.blade.php *
			 ****************************************************************************************/
			 
			 
			var rollType = document.createElement("div");
			var content = "<input type=radio name='rollType' id=Adv value='Adv'><label for='Adv'>Adv</label>"
						+ "<input type=radio name='rollType' id=Nor value='Nor' checked=true><label for='Nor'>Nor</label>"
						+ "<input type=radio name='rollType' id=Dis value='Dis'><label for='Dis'>Dis</label>";
			rollType.innerHTML = content;
			rollType.style ='Position: Absolute; Left: 1755px; Top: 10px; color: yellow;';
			document.body.appendChild(rollType);

			updateCall(function(content)
			{
				eval(content);
								
				var options = document.createElement("select");
				options.id = "options";
				options.style = "Position: Absolute; Left: 1760px; Top: 35px; color: yellow; background-color: blue;"; 
				options.addEventListener("change",function(e)
				{
					if(document.getElementById("options").value!="Select Roll")
					{
						var skill = document.getElementById("options").value;
						document.getElementById("options").value="";
						onRollExecute(rolls[skill],skill);
					}
				});
										
				for(const key of Object.keys(rolls))
				{
					var option = document.createElement("option");
					option.id = key;
					option.text = key;
					option.value = key;
					options.appendChild(option);
				}	
			
				document.body.appendChild(options);
				
			},"resources/sheets/"+player+".js");
