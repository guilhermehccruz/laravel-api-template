<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
	/**
	 * Authenticates the user.
	 *
	 * @param \App\Http\Requests\LoginRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function login(LoginRequest $request)
	{
		$credentials = $request->validated();

		$user = User::with(['roles', 'permissions'])->where('email', $credentials['email'])->first();

		if (!$user or !Hash::check($credentials['password'], $user->password)) {
			return response([
				'message' => 'Incorrect email or password'
			], 400);
		}

		return response([
			'message' => 'User logged in',
			'token' => $user->createToken('token')->plainTextToken,
			'user' => $user,
		]);
	}

	/**
	 *  Unauthenticates the user.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout()
	{
		auth()->user()->tokens()->delete();

		return response(['message' => 'User logged out']);
	}
}
