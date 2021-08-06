<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\DeletePermissionRequest;
use App\Http\Requests\Permission\ShowPermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(ShowPermissionRequest $request)
	{
		try {
			return response(['permission' => Permission::all()]);
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
	public function store(CreatePermissionRequest $request)
	{
		$permission = $request->validated();
		$permission['guard_name'] = 'web';

		try {
			return response([
				'message' => 'Permission created successfully',
				'permission' => Permission::create($permission)
			], 201);
		} catch (Exception $ex) {
			return response([
				'message' => 'An error has occurred',
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
	public function show(ShowPermissionRequest $request, $id)
	{
		try {
			return response(['permission' => Permission::findOrFail($id)]);
		} catch (ModelNotFoundException $ex) {
			return response(['message' => 'Permission not found'], 404);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdatePermissionRequest $request, $id)
	{
		try {
			$permission = Permission::findOrFail($id);
			$permission->update($request->validated());

			return response([
				'message' => 'Permission updated successfully',
				'permission' => $permission
			]);
		} catch (ModelNotFoundException $ex) {
			return response(['message' => 'Permission not found'], 404);
		} catch (Exception $ex) {
			return response([
				'message' => 'An error has occurred',
				'error' => $ex->getMessage()
			]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(DeletePermissionRequest $request, $id)
	{
		try {
			Permission::findOrFail($id)->delete();

			return response(['message' => 'Permission deleted']);
		} catch (ModelNotFoundException $ex) {
			return response(['error' => 'Permission not found'], 404);
		}
	}
}
