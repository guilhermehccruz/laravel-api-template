<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Reset cached roles and permissions
		app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

		//* Roles
		Role::insert([
			['name' => 'admin'],
			['name' => 'user'],
		]);

		//* Permissions
		Permission::insert([
			['name' => 'show-users'],
			['name' => 'create-users'],
			['name' => 'update-users'],
			['name' => 'delete-users'],

			['name' => 'show-roles'],
			['name' => 'create-roles'],
			['name' => 'update-roles'],
			['name' => 'delete-roles'],

			['name' => 'show-permissions'],
			['name' => 'create-permissions'],
			['name' => 'update-permissions'],
			['name' => 'delete-permissions'],
		]);
	}
}
