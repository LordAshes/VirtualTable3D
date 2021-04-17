			/***********************************************************************
			 * Update functionality inserted from views/componets/Common.blade.php *
			 ***********************************************************************/

			var pulse = setInterval(function() { updateGet(updateCallback); },1000);	

			function updateCallback(code)
			{
				eval(code);
			}
			
			// Holds the sequence number of the last update
			var lastTransaction=0;

			//
			// This function is used to send updates to the server (to be distributed to others)
			//
			function updateSend(update,csrf)
			{
				if(update!=undefined)
				{
					var xhttp = new XMLHttpRequest();
					xhttp.open("POST", "api/transactions", true);
					// xhttp.setRequestHeader('Content-Type', 'application/js; charset=UTF-8');
					xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
					xhttp.setRequestHeader("X-CSRF-TOKEN", csrf);
					xhttp.send("source="+player+"&module="+module+"&content="+update);
				}
			}

			//
			// This function is used to obtain new updates from the server
			//
			function updateGet(callback)
			{
				// Make a request to get updates since the given sequence number
				var xhttp = new XMLHttpRequest();
				xhttp.open("GET", "api/transactions/"+module+"/except/none/since/"+lastTransaction, true);
				// Create handler for returned data
				xhttp.onreadystatechange = function()
				{
					if (this.readyState == 4 && this.status == 200)
					{
						// Process only if the response has more than one line (meaning at least one update)
						if(xhttp.responseText.indexOf("\r\n")>=0)
						{
							// Server returns Javascript ready script which can be evaluated
							callback(xhttp.responseText);
						}
					}
				};
				// Send request
				xhttp.send();
			}

