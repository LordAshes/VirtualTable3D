			/***********************************************************************
			 * Notify functionality inserted from views/componets/Common.blade.php *
			 ***********************************************************************/

			var notifyPulse = null;

			// Hold current notification entries
			var numChatEntries = 55;
			var numChatShow = numChatEntries;
			var chat=[];
			
			// Create tooltip element
			var tooltip = document.createElement("span");
			tooltip.id = "tooltip";
			tooltip.name = "tooltip";
			tooltip.style = "position: absolute; left: 0px; top: 0px; color: #ADD8E6; background-color: black;  font-family: 'Lucida Console', 'Courier New', monospace; z-index: 100; visibility: hidden;";
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
				el.style = "position: absolute; left: 10px; top: "+(45+i*16)+"px; height: 16px; padding-top: 0px; width: 310px; color: #ADD8E6; background-color: rgba(0, 0, 0, 0.5); font-family: 'Lucida Console', 'Courier New', monospace;";			
				el.addEventListener('mouseenter',function(e){e.preventDefault(); e.stopPropagation(); showTooltip(this);});
				document.body.appendChild(el);
				chat.push({short: "", full: ""});
			}
				
			function notify(short, full)
			{
				updateSend("notify_basic(\""+encodeURIComponent(short)+"\",\""+encodeURIComponent(full)+"\");\r\n",csrf);
			}
						
			function notify_basic(short,full)
			{
				chat.push({short: short, full: full});
				chat.shift();
				for(var i=0; i<numChatShow; i++)
				{
					showNotice(document.getElementById("Chat"+i));
				}
				console.log(chat);
			}
						
			function showNotice(dst)
			{
				var id = parseInt(numChatEntries)-parseInt(dst.id.substring(4))-1;
				dst.innerHTML = "&nbsp;"+chat[id].short;
			}

			function showTooltip(dst)
			{
				var id = parseInt(numChatEntries)-parseInt(dst.id.substring(4))-1;
				if(chat[id].full.indexOf("&boxh")<0)
				{
					var el = document.getElementById("tooltip");
					el.style.left = (parseInt(dst.style.left)+20)+"px"
					el.style.top = (parseInt(dst.style.top)+0)+"px"
					el.style.visibility = "visible";
					el.innerHTML = "&nbsp;"+chat[id].full.substring(chat[id].full.indexOf(":")+1).trim();
				}
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
				if(numChatShow==numChatEntries){numChatShow=3;}else{numChatShow=numChatEntries;}
				for(var i=0; i<numChatShow; i++)
				{
					document.getElementById("Chat"+i).style.visibility = "visible";
				}				
			}
