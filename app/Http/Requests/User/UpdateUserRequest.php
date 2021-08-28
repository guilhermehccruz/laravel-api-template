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
		return [
			'user.name' => [
				'string'
			],
			'user.email' => [
				'string',
				'email',
				'unique:users,email,' . $this->route()->user->id . ',id,deleted_at,NULL'
			],
			'user.password' => [
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
