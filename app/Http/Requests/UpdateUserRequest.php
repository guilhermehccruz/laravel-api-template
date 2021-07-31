<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'user.name' => [
				'string'
			],
			'user.email' => [
				'string',
				'email',
				'unique:users,email,' . $this->id
			],
			'user.password' => [
				'string',
				'confirmed'
			],
			'user.status' => [
				'boolean'
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
