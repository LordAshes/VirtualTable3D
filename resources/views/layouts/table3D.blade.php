@extends('templates.table')

@section('module3D')

		<input type=hidden id="_token" name="_token" value="{{ csrf_token() }}" /> 

		<script type="module">
								
			var csrf = document.getElementById("_token").value;
		
			var query = document.location.href+"&";
			var module = query.substring(query.indexOf("module=")+"module=".length);
			module = module.substring(0,module.indexOf("&"));
			var player = query.substring(query.indexOf("player=")+"player=".length);
			player = player.substring(0,player.indexOf("&"));
			var gm = (player=="GM");
			
			@include("components\Common");
																					
			@include("components\Scene");
			
			@include("components\Updates");
						
			@include("components\Mouse");
			
			@include("components\Keyboard");
			
			@include("components\Notify");
																					
			@include("components\Dice");
			
			function bounded(last,min,max)
			{
				if(isNaN(last)==true)
				{
					last = 0;
				}
				if(last<min){ return min; }
				if(last>max){ return max; }
				return last;
			}
								
		</script>

@endsection