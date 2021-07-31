<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$users = [
			[
				[
					'name' => 'admin',
					'email' => 'admin@email.com',
					'password' => 'admin'
				],
				'role' => [
					'admin'
				]
			],
			[
				[
					'name' => 'user',
					'email' => 'user@email.com',
					'password' => 'user'
				],
				'role' => [
					'user'
				]
			]
		];

		foreach ($users as $user) {
			$user[0]['password'] = bcrypt($user[0]['password']);
			$createdUser = User::create($user[0]);
			$createdUser->syncRoles($user['role']);
		}
	}
}
