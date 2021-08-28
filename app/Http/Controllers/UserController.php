<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\ShowUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
	/**
	 * Display a listing of users.
	 *
	 * @param  \App\Http\Requests\User\ShowUserRequest  $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(ShowUserRequest $request): JsonResponse
	{
		return response()->json(['users' => User::with(['roles', 'permissions'])->paginate()]);
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @param  \App\Http\Requests\User\CreateUserRequest  $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateUserRequest $request): JsonResponse
	{
		try {
			$user = User::create($request->validated()['userData']);

			if (isset($request->validated()['roles']))
				$user->syncRoles($request->validated()['roles']);

			if (isset($request->validated()['permissions']))
				$user->syncPermissions($request->validated()['permissions']);

			return response()->json([
				'message' => 'User created successfully',
				'user' => $user
			], 201);
		} catch (Exception $ex) {
			return response()->json(
				['error' => $ex->getMessage()],
				500
			);
		}
	}

	/**
	 * Display the specified user.
	 *
	 * @param  \App\Http\Requests\User\ShowUserRequest  $request
	 * @param  \App\Models\User $user
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(ShowUserRequest $request, User $user): JsonResponse
	{
		return response()->json(['user' => $user->load(['roles', 'permissions'])]);
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  \App\Http\Requests\User\UpdateUserRequest  $request
	 * @param  \App\Models\User $user
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(UpdateUserRequest $request, User $user): JsonResponse
	{
		try {
			if (isset($request->validated()['user'])) {
				$user->update($request->validated()['user']);
			}

			if (isset($request->validated()['roles']))
				$user->syncRoles($request->validated()['roles']);

			if (isset($request->validated()['permissions']))
				$user->syncPermissions($request->validated()['permissions']);

			return response()->json([
				'message' => 'User updated successfully',
				'user' => $user
			]);
		} catch (Exception $ex) {
			return response()->json([
				'error' => $ex->getMessage()
			], 500);
		}
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  \App\Http\Requests\User\DeleteUserRequest  $request
	 * @param  \App\Models\User $user
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(DeleteUserRequest $request, User $user): JsonResponse
	{
		$user->delete();

		return response()->json(['message' => 'User deleted']);
	}
}
