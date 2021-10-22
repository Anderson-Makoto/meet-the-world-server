<?php

use App\Http\Controllers\api\LocalController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\TestController;
use App\Http\Controllers\api\TipoController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
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

Route::post("user/register", [UserController::class, "register"]);
Route::post("user/login", [UserController::class, "login"]);
Route::get('local', [LocalController::class, "getAll"]);
Route::get("tipo", [TipoController::class, "getAll"]);

route::middleware(["auth:sanctum"])->group(function () {
    Route::get("user/logout/{id}", [UserController::class, "logout"]);
    Route::put('user/{id}', [UserController::class, "updateUser"]);
    Route::get("post/getPostsResume", [PostController::class, "getPostsResume"]);
    Route::resource('post', PostController::class);
});
