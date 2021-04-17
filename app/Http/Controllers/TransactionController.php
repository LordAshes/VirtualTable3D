<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{	
    public function list()
	{
		return Transaction::all();
	}

    public function create(Request $request)
	{
		$request->validate(
		[
			'module' => 'required|max:128',
			'source' => 'required',
			'content' => 'required'
		]);
		return Transaction::create($request->all());
	}

    public function read($id)
	{
		return Transaction::find($id);
	}
 
    public function update(Request $request, $id)
	{
		$product = Transaction::find($id);
		$product->update($request->all());
		return $product;
	}

    public function delete($id)
	{
		return Transaction::create($id);
	}
	
    public function since($module, $player, $seqnum)
	{
		$response = "";
		$entries = Transaction::where([
										['module',$module],
										['source',"!=",$player],
										['id','>',$seqnum]
									  ])->get();
		$lastTransaction = 0;
		foreach($entries as $entry)
		{
			$response = $response . $entry['content'] . "\r\n";
			if($entry['id']>$lastTransaction){$lastTransaction=$entry['id'];}
		}
		$response = $response . "lastTransaction=".$lastTransaction.";";
		return response($response,200);
	}
}

?>