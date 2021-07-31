<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$credentials = $request->validate([
			'email' => 'required|string|exists:users,email',
			'password' => 'required|string',
		]);

		$user = User::where('email', $credentials['email'])->first();

		if (!$user or !Hash::check($credentials['password'], $user->password)) {
			return response([
				'message' => 'Incorrect email or password'
			], 400);
		}

		$token = $user->createToken('token')->plainTextToken;

		return response([
			'message' => 'User logged in',
			'user' => $user,
			'token' => $token
		]);
	}

	public function logout()
	{
		auth()->user()->tokens()->delete();

		return response(['message' => 'User logged out']);
	}
}
