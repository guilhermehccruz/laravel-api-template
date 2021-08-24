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
				'user' => [
					'name' => 'admin',
					'email' => 'admin@email.com',
					'password' => 'admin'
				],
				'role' => [
					'admin'
				]
			],
			[
				'user' => [
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
			User::create($user['user'])->syncRoles($user['role']);
		}
	}
}
