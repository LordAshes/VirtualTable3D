<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableController extends Controller
{
    public function main()
	{
		return view("Layouts\Table3D");
	}
		
	public function content($folder, $name)
	{
		$supported = 
		[
			"TXT" => "text/plain",
			"JS" => "text/javascript",
			"GIF" => "image/gif",
			"JPEG" => "image/jpeg",
			"JPG" => "image/jpeg",
			"PNG" => "image/png",
			"SVG" => "image/svg+xml",
			"GLB" => "model/gltf-binary",
		];
	
		if($folder!=""){$folder=$folder."\\";}
	
		$ext = strtoupper(substr($name,strrpos($name,".")+1));
		if(array_key_exists($ext,$supported)===false)
		{
			return response("Forbidden",403);
		}
		else
		{		
			$name = base_path()."\\resources\\".$folder.$name;
			if(file_exists($name))
			{
				$fp = fopen($name, 'rb');
				header("Content-Type: " . $supported[$ext]);
				header("Content-Length: " . filesize($name));
				fpassthru($fp);
				fclose($fp);
			}
			else
			{
				return response("Not Found",404);
			}
		}
	}
}
