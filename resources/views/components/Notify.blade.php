			/***********************************************************************
			 * Notify functionality inserted from views/componets/Common.blade.php *
			 ***********************************************************************/

			var notifyPulse = null;
			
			function notify(txt, interval)
			{
				notify_basic(txt, interval);
				updateSend("notify_basic(\""+encodeURIComponent(txt)+"\","+interval+");\r\n",csrf);
			}
			
			function notify_basic(txt, interval)
			{
				if(interval==undefined){interval = 3000;}
				clearTimeout(notifyPulse);
				document.getElementById("Action").innerHTML = txt;
				notifyPulse = setTimeout('document.getElementById("Action").innerHTML = "";',interval);
			}

