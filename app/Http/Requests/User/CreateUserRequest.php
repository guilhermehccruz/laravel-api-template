<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreateUserRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Gate::authorize('create-users');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'userData.name' => [
				'required',
				'string'
			],
			'userData.email' => [
				'required',
				'string',
				'email',
				'unique:users,email,NULL,id,deleted_at,NULL'
			],
			'userData.password' => [
				'required',
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
			],
		];
	}
}
