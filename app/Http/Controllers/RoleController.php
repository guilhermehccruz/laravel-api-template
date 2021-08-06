<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\ShowRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(ShowRoleRequest $request)
	{
		try {
			return response(['role' => Role::with('permissions')->get()]);
		} catch (Exception $ex) {
			return response([
				'message' => 'An error has occurred',
				'error' => $ex->getMessage()
			], 500);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateRoleRequest $request)
	{
		$role['name'] = $request->validated()['name'];
		$role['guard_name'] = 'web';

		try {
			$role = Role::create($role);

			if (isset($request->validated()['permissions']))
				$role->syncPermissions($request->validated()['permissions']);

			return response([
				'message' => 'Role created successfully',
				'role' => $role
			], 201);
		} catch (Exception $ex) {
			return response([
				'message' => 'Ocorreu um erro',
				'error' => $ex->getMessage()
			]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(ShowRoleRequest $request, $id)
	{
		try {
			return response(['role' => Role::with(['permissions'])->findOrFail($id)]);
		} catch (Exception) {
			return response(['error' => 'Role not found'], 404);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRoleRequest $request, $id)
	{
		try {
			$role = Role::findOrFail($id);

			$role->update($request->validated());

			if (isset($request->validated()['permissions']))
				$role->syncPermissions($request->validated()['permissions']);

			return response([
				'message' => 'Role updated successfully',
				'role' => $role
			]);
		} catch (ModelNotFoundException) {
			return response(['message' => 'Role not found'], 404);
		} catch (Exception $ex) {
			return response(['message' => 'Ocorreu um erro', 'error' => $ex->getMessage()]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$this->authorize('deleteRoles');

		try {
			Role::findOrFail($id)->delete();

			return response(['message' => 'Role deleted']);
		} catch (ModelNotFoundException) {
			return response(['error' => 'Role not found'], 404);
		}
	}
}
