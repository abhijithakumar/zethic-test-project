<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::post('/logout',[AuthController::class,'logout']);

    Route::group(['middleware' => ['role:admin']], function () {
        //
        Route::post('/adduser',[UserController::class,'addUser']);
    });
    Route::post('/edituser/{id}',[UserController::class,'editUser']);
    Route::get('/edituserdata/{id}',[UserController::class,'editUserData']);
    Route::get('/viewuser',[UserController::class,'viewUser']);
    Route::get('/getuserrole',[UserController::class,'getUserRole']);
});