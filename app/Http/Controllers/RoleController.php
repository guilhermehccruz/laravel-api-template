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
	 * @param \App\Http\Requests\Role\ShowRoleRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(ShowRoleRequest $request): JsonResponse
	{
		return response()->json(['role' => Role::with('permissions')->get()]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\Role\CreateRoleRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreateRoleRequest $request): JsonResponse
	{
		$role['name'] = $request->validated()['name'];
		$role['guard_name'] = 'web';

		$role = Role::create($role);

		if (isset($request->validated()['permissions']))
			$role->syncPermissions($request->validated()['permissions']);

		return response()->json([
			'message' => 'Role created successfully',
			'role' => $role
		], 201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Http\Requests\Role\ShowRoleRequest $request
	 * @param  \Spatie\Permission\Models\Role $role
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(ShowRoleRequest $request, Role $role): JsonResponse
	{
		return response()->json(['role' => $role->load(['permissions'])]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\Role\UpdateRoleRequest $request
	 * @param  \Spatie\Permission\Models\Role $role
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(UpdateRoleRequest $request, Role $role): JsonResponse
	{
		$role->update($request->validated());

		if (isset($request->validated()['permissions']))
			$role->syncPermissions($request->validated()['permissions']);

		return response()->json([
			'message' => 'Role updated successfully',
			'role' => $role
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Http\Requests\Role\DeleteRoleRequest $request
	 * @param  \Spatie\Permission\Models\Role $role
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(DeleteRoleRequest $request, Role $role): JsonResponse
	{
		$role->delete();

		return response()->json(['message' => 'Role deleted']);
	}
}
