<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public Routes
Route::post('/login', [AuthController::class, 'login'])
	->name('login');

// Authenticated routes
Route::group(['middleware' => ['auth:sanctum']], function () {
	Route::post('/logout', [AuthController::class, 'logout'])
		->name('logout');

	Route::apiResources([
		'users' => UserController::class,
		'roles' => RoleController::class,
		'permissions' => PermissionController::class
	]);
});
