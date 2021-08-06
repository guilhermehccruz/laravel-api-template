<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateUserRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Gate::authorize('update-users');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		// dd($this->user);
		return [
			'userData.name' => [
				'string'
			],
			'userData.email' => [
				'string',
				'email',
				'unique:users,email,' . $this->user
			],
			'userData.password' => [
				'string',
				'confirmed'
			],

			'roles' => [
				'array'
			],
			'roles.*' => [
				'exists:roles,name'
			],

			'permissions' => [
				'array'
			],
			'permissions.*' => [
				'exists:permissions,name'
			]
		];
	}
}
