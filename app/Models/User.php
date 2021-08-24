<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
	use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [];

	/**
	 * Encrypt the user's password.
	 *
	 * @param  string  $password
	 */
	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = bcrypt($password);
	}


	/**
	 * The attributes that should be cast to native types.
	 */
	public function roles()
	{
		return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
	}

	/**
	 * The attributes that should be cast to native types.
	 */
	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'model_has_permissions', 'model_id', 'permission_id');
	}
}
