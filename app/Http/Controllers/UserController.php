<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\ShowUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
	/**
	 * Display a listing of users.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(ShowUserRequest $request)
	{
		try {
			return response(['users' => User::with(['roles', 'permissions'])->paginate(15)]);
		} catch (Exception $ex) {
			return response([
				'message' => 'An error has ocurred',
				'error' => $ex->getMessage()
			], 500);
		}
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @param  \App\Http\Requests\User\CreateUserRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateUserRequest $request)
	{
		try {
			$user = $request->validated()['userData'];

			$user['password'] = bcrypt($user['password']);
			$user = User::create($user);

			if ($request->validated()['roles'])
				$user->syncRoles($request->validated()['roles']);

			if ($request->validated()['permissions'])
				$user->syncPermissions($request->validated()['permissions']);

			return response(['message' => 'User created successfully', 'user' => $user], 201);
		} catch (Exception $ex) {
			return response(['error' => $ex->getMessage()]);
		}
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(ShowUserRequest $request, $id)
	{
		try {
			return response(['user' => User::with(['roles', 'permissions'])->findOrFail($id)]);
		} catch (ModelNotFoundException $ex) {
			return response(['error' => 'User not found'], 404);
		}
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  \App\Http\Requests\User\UpdateUserRequest  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateUserRequest $request, $id)
	{
		try {
			$user = User::findOrFail($id);

			if (isset($request->validated()['userData'])) {
				$userData = $request->validated()['userData'];
				if ($userData['password'])
					$userData['password'] = bcrypt($userData['password']);

				$user->update($userData);
			}

			if (isset($request->validated()['roles']))
				$user->syncRoles($request->validated()['roles']);

			if (isset($request->validated()['permissions']))
				$user->syncPermissions($request->validated()['permissions']);

			return response([
				'message' => 'User updated successfully',
				'user' => $user
			]);
		} catch (ModelNotFoundException $ex) {
			return response(['error' => 'User not found'], 404);
		} catch (Exception $ex) {
			return response([
				'message' => 'An error has ocurred',
				'error' => $ex->getMessage()
			], 500);
		}
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(DeleteUserRequest $request, $id)
	{
		try {
			User::findOrFail($id)->delete();

			return response(['message' => 'User deleted']);
		} catch (ModelNotFoundException $ex) {
			return response(['error' => 'User not found'], 404);
		}
	}
}
