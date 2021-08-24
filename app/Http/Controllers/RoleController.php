<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\DeleteRoleRequest;
use App\Http\Requests\Role\ShowRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(ShowRoleRequest $request): JsonResponse
	{
		try {
			return response()->json(['role' => Role::with('permissions')->get()]);
		} catch (Exception $ex) {
			return response()->json([
				'message' => 'An error has occurred',
				'error' => $ex->getMessage()
			], 500);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateRoleRequest $request): JsonResponse
	{
		$role['name'] = $request->validated()['name'];
		$role['guard_name'] = 'web';

		try {
			$role = Role::create($role);

			if (isset($request->validated()['permissions']))
				$role->syncPermissions($request->validated()['permissions']);

			return response()->json([
				'message' => 'Role created successfully',
				'role' => $role
			], 201);
		} catch (Exception $ex) {
			return response()->json([
				'message' => 'Ocorreu um erro',
				'error' => $ex->getMessage()
			]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(ShowRoleRequest $request, Role $role): JsonResponse
	{
		return response()->json(['role' => $role->load(['permissions'])]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(UpdateRoleRequest $request, Role $role): JsonResponse
	{
		try {
			$role->update($request->validated());

			if (isset($request->validated()['permissions']))
				$role->syncPermissions($request->validated()['permissions']);

			return response()->json([
				'message' => 'Role updated successfully',
				'role' => $role
			]);
		} catch (Exception $ex) {
			return response()->json([
				'message' => 'Ocorreu um erro',
				'error' => $ex->getMessage()
			]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(DeleteRoleRequest $request, Role $role): JsonResponse
	{
		$role->delete();

		return response()->json(['message' => 'Role deleted']);
	}
}
