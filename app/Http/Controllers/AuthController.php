<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
	/**
	 * Authenticates the user.
	 *
	 * @param \App\Http\Requests\LoginRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(LoginRequest $request): JsonResponse
	{
		$credentials = $request->validated();

		$user = User::with(['roles', 'permissions'])->where('email', $credentials['email'])->first();

		if (!$user or !Hash::check($credentials['password'], $user->password)) {
			return response()->json([
				'message' => 'Incorrect email or password'
			], 400);
		}

		return response()->json([
			'message' => 'User logged in',
			'token' => $user->createToken($user->password)->plainTextToken,
			'user' => $user,
		]);
	}

	/**
	 *  Unauthenticates the user.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout(): JsonResponse
	{
		auth()->user()->tokens()->delete();

		return response()->json(['message' => 'User logged out']);
	}
}
