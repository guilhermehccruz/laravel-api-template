<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
	public function index()
	{
		$this->authorize('showUsers');

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
	 * @param  \App\Http\Requests\CreateUserRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateUserRequest $request)
	{
		$this->authorize('createUsers');

		try {
			$user = $request->validated()['user'];

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
	public function show($id)
	{
		$this->authorize('showUsers');

		try {
			return response(['user' => User::with(['roles', 'permissions'])->findOrFail($id)]);
		} catch (Exception) {
			return response(['error' => 'User not found'], 404);
		}
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  \App\Http\Requests\UpdateUserRequest  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateUserRequest $request, $id)
	{
		$this->authorize('updateUser');

		try {
			$user = User::findOrFail($id);

			if ($request->password)
				$request->password = bcrypt($request->password);

			$user->update($request->validated()['user']);

			$user->syncRoles($request->validated()['roles']);

			$user->syncPermissions($request->validated()['permissions']);

			return response([
				'message' => 'User updated successfully',
				'user' => $user
			]);
		} catch (ModelNotFoundException) {
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
	public function destroy($id)
	{
		$this->authorize('deleteUser');

		try {
			User::findOrFail($id)->delete();

			return response(['message' => 'User deleted']);
		} catch (ModelNotFoundException) {
			return response(['error' => 'User not found'], 404);
		}
	}
}
