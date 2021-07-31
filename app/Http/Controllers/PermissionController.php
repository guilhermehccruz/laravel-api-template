<?php

namespace App\Http\Controllers;

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
	public function index()
	{
		$this->authorize('showPermissions');

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
	public function store(Request $request)
	{
		$this->authorize('createPermissions');

		$permission = $request->validate([
			'name' => 'required|string|unique:permissions,name'
		]);

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
	public function show($id)
	{
		$this->authorize('showPermissions');

		try {
			return response(['permission' => Permission::findOrFail($id)]);
		} catch (ModelNotFoundException) {
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
	public function update(Request $request, $id)
	{
		$this->authorize('updatePermissions');

		try {
			$permission = Permission::findOrFail($id);

			$permission->update($request->validate(['name' => 'string']));

			return response([
				'message' => 'Permission updated successfully',
				'permission' => $permission
			]);
		} catch (ModelNotFoundException) {
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
	public function destroy($id)
	{
		$this->authorize('deletePermissions');

		try {
			Permission::findOrFail($id)->delete();

			return response(['message' => 'Permission deleted']);
		} catch (ModelNotFoundException) {
			return response(['error' => 'Permission not found'], 404);
		}
	}
}
