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
		$roles = [
			'admin',
			'user'
		];

		foreach ($roles as $role) {
			Role::create(['name' => $role]);
		}

		//* Permissions
		$permissions = [
			'show-users',
			'create-users',
			'update-users',
			'delete-users',

			'show-roles',
			'create-roles',
			'update-roles',
			'delete-roles',

			'show-permissions',
			'create-permissions',
			'update-permissions',
			'delete-permissions',
		];

		foreach ($permissions as $permission) {
			Permission::create(['name' => $permission]);
		};
	}
}
