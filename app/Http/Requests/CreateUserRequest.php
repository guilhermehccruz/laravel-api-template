<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
				'required',
				'string'
			],
			'user.email' => [
				'required',
				'string',
				'email',
				'unique:users,email'
			],
			'user.password' => [
				'required',
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
			],
		];
	}
}
