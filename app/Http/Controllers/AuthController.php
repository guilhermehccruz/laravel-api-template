<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
	public function login(LoginRequest $request)
	{
		$credentials = $request->validated();

		$user = User::with(['roles', 'permissions'])->where('email', $credentials['email'])->first();

		if (!$user or !Hash::check($credentials['password'], $user->password)) {
			return response([
				'message' => 'Incorrect email or password'
			], 400);
		}

		$token = $user->createToken('token')->plainTextToken;

		return response([
			'message' => 'User logged in',
			'token' => $token,
			'user' => $user,
		]);
	}

	public function logout()
	{
		auth()->user()->tokens()->delete();

		return response(['message' => 'User logged out']);
	}
}
