<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Virtual 3D Table</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<style>
			body { background-color: #ccc; color: #000; }
			a { color: #f00; }
		</style>
	</head>

	<body oncontextmenu="return false;">
	    <span Id=GuiInfo Style="Position: Absolute; Left: 10px; Top: 10px; color:yellow; background-color: black;"></span>
		<span Id=Action Style="Position: Absolute; Left: 10px; Top: 30px; color:yellow; background-color: black;"></span>
		
		@yield('module3D')

	</body>
</html>
