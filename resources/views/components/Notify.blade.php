			/***********************************************************************
			 * Notify functionality inserted from views/componets/Common.blade.php *
			 ***********************************************************************/

			var notifyPulse = null;

			// Hold current notification entries
			var numChatEntries = 30;
			var numChatShow = numChatEntries;
			var chat=[];
			
			// Create tooltip element
			var tooltip = document.createElement("span");
			tooltip.id = "tooltip";
			tooltip.name = "tooltip";
			tooltip.style = "position: absolute; left: 0px; top: 0px; color: #ADD8E6; background-color: black; z-index: 100; visibility: hidden;";
			tooltip.addEventListener('mouseover',function(e){e.preventDefault(); e.stopPropagation();});
			tooltip.addEventListener('mousedown',function(e){e.preventDefault(); e.stopPropagation(); adjustChat();});
			document.body.appendChild(tooltip);
	
			// Create chat entries
			document.body.addEventListener('mouseover',function(e){e.preventDefault(); e.stopPropagation(); clearTooltip(this);});
			for(var i=0; i<numChatShow; i++)
			{
				var el = document.createElement("div");
				el.id = "Chat"+i;
				el.name = "Chat"+i;
				el.style = "position: absolute; left: 10px; top: "+(45+i*30)+"px; height: 25px; padding-top: 5px; width: 300px; color: #ADD8E6; background-color: rgba(0, 0, 0, 0.5);";			
				el.addEventListener('mouseenter',function(e){e.preventDefault(); e.stopPropagation(); showTooltip(this);});
				document.body.appendChild(el);
				chat.push({short: "", full: ""});
			}
				
			function notify(txt, interval)
			{
				updateSend("notify_basic(\""+encodeURIComponent(txt)+"\","+interval+");\r\n",csrf);
			}
			
			function abc()
			{
				console.log(chat);
			}
			
			function notify_basic(txt, interval)
			{
				var short = txt.replace(/<[^>]*>/g, '');
				if(short.indexOf(":")>1)
				{
					short = short.substring(0,short.indexOf(":")+1)+" "+short.substring(short.lastIndexOf("=")+1);
				}
				chat.push({short: short, full: txt});
				chat.shift();
				for(var i=0; i<numChatShow; i++)
				{
					showNotice(document.getElementById("Chat"+i));
				}
			}
						
			function showNotice(dst)
			{
				var id = parseInt(numChatEntries)-parseInt(dst.id.substring(4))-1;
				dst.innerHTML = "&nbsp;"+chat[id].short;
			}

			function showTooltip(dst)
			{
				var id = parseInt(numChatEntries)-parseInt(dst.id.substring(4))-1;
				var el = document.getElementById("tooltip");
				el.style.left = (parseInt(dst.style.left)+10)+"px"
				el.style.top = (parseInt(dst.style.top)+10)+"px"
				el.style.visibility = "visible";
				el.innerHTML = "&nbsp;"+chat[id].full.substring(chat[id].full.indexOf(":")+1).trim();
			}
			
			function clearTooltip(dst)
			{
				var el = document.getElementById("tooltip");
				el.innerHTML = "";
				el.style.visibility = "hidden";
			}
			
			function adjustChat()
			{
				for(var i=0; i<numChatEntries; i++)
				{
					document.getElementById("Chat"+i).style.visibility = "hidden";
				}
				if(numChatShow==numChatEntries){numChatShow=1;}else{numChatShow=numChatEntries;}
				for(var i=0; i<numChatShow; i++)
				{
					document.getElementById("Chat"+i).style.visibility = "visible";
				}				
			}

			function guid()
			{
				return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c)
				{
					var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
					return v.toString(16);
				});
			}

