			/*****************************************************************************************
			 * Character Sheet functionality inserted from views/componets/CharacterSheets.blade.php *
			 ****************************************************************************************/
			 
			updateCall(function(content)
			{
				eval(content);
				var options = document.createElement("select");
				options.id = "options";
				options.style = "Position: Absolute; Left: 1775px; Top: 20px; color: yellow; background-color: blue;"; 
				options.addEventListener("change",function(e)
				{
					if(document.getElementById("options").value!="Select Roll")
					{
						document.getElementById("Roll").value = document.getElementById("options").value;
						document.getElementById("options").value = "";
						onRollChange(null);
					}
				});
										
				for(const key of Object.keys(rolls))
				{
					var option = document.createElement("option");
					option.id = key;
					option.text = key;
					option.value = rolls[key];
					options.appendChild(option);
				}	
			
				document.body.appendChild(options);
				
			},"resources/sheets/"+player+".js");
