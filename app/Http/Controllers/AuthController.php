<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

namespace App\Http\Controllers;
namespace App\Models\Users;

class AuthController extends Controller
{
    public function register(Request $request)
	{
		// Validate entry
		$fields = $request->validate(
		[
			'name' => 'required|string',
			'email' => 'required|string|unique:users,email',
			'password' => 'required|string|confirmed'
		]);
		
		// Create user
		$user = User::create(
		[
			'name' => $fields['name'],
			'email' => $fields['email'],
			'password' => bcrypt($fields['password'])
		]);
		
		// Create token
		$token = $user->createToken('transactionAccessToken')->plainTextToken;
		
		// Return response
		return response(
		[
			'user' => $user,
			'token' => $token
		], 201);
	}
	
    public function login(Request $request)
	{
		// Validate entry
		$fields = $request->validate(
		[
			'email' => 'required|string',
			'password' => 'required|string'
		]);
		
		// Check email
		$user = User::where('email', $fields['email']->first();
		
		// Check password
		if(!$user || !Hash::check($fields['password'], $user->password))
		{
				return response(
				[
					'message' -> 'Bad credentails'
				], 401);
		}
				
		// Create token
		$token = $user->createToken('transactionAccessToken')->plainTextToken;
				
		// Return response
		return response(
		[
			'user' => $user,
			'token' => $token
		], 200);
	}
	
	public function logout(Request $request)
	{
		auth()->user()->tokens()->delete();
		
		return [ 'message' => 'Logged out' ];
	}
}
