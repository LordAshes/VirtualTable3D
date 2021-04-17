			/*******************************************************************
			 * Common variables inserted from views/componets/Common.blade.php *
			 *******************************************************************/

			var STATE = { NONE: - 1, ZOOM: 1, WORLD_MOVE: 2, WORLD_LIFT: 3, WORLD_TILT: 4, WORLD_ROTATE: 5, OBJ_MOVE: 10, OBJ_ROTATE: 11, OBJ_LIFT: 12 };
			var state = STATE.NONE;

			var objectInfo;
			var speedRotate = 5;
			var speedMove = 0.01;
			var speedLift = 0.01;
						
			var angle = 0;
			var tilt = -12.5;
			var zoom = 1;
