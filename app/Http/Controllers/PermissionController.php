<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\DeletePermissionRequest;
use App\Http\Requests\Permission\ShowPermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 * @param \App\Http\Requests\Permission\ShowPermissionRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(ShowPermissionRequest $request): JsonResponse
	{
		try {
			return response()->json(['permission' => Permission::all()]);
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
	 * @param  \App\Http\Requests\Permission\CreatePermissionRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CreatePermissionRequest $request): JsonResponse
	{
		$permission = $request->validated();
		$permission['guard_name'] = 'web';

		try {
			return response()->json([
				'message' => 'Permission created successfully',
				'permission' => Permission::create($permission)
			], 201);
		} catch (Exception $ex) {
			return response()->json([
				'message' => 'An error has occurred',
				'error' => $ex->getMessage()
			]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Http\Requests\Permission\ShowPermissionRequest $request
	 * @param  \Spatie\Permission\Models\Permission  $permission
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(ShowPermissionRequest $request, Permission $permission): JsonResponse
	{
		return response()->json(['permission' => $permission]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Permission\UpdatePermissionRequest $request
	 * @param  \Spatie\Permission\Models\Permission  $permission
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(UpdatePermissionRequest $request, Permission $permission): JsonResponse
	{
		try {
			$permission->update($request->validated());

			return response()->json([
				'message' => 'Permission updated successfully',
				'permission' => $permission
			]);
		} catch (Exception $ex) {
			return response()->json([
				'message' => 'An error has occurred',
				'error' => $ex->getMessage()
			]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Http\Requests\Permission\DeletePermissionRequest $request
	 * @param  \Spatie\Permission\Models\Permission  $permission
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(DeletePermissionRequest $request, Permission $permission): JsonResponse
	{
		$permission->delete();

		return response()->json(['message' => 'Permission deleted']);
	}
}
