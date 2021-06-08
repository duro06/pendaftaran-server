<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\MeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return ['data'=>$request->user()];
});

// Auth
Route::group(['prefix' => '/auth'], function() {
    Route::group(['middleware'=>'auth:sanctum'], function(){
        Route::get('logout', [LoginController::class, 'logout']);
    });

    Route::post('register', [RegisterController::class, 'register']); // ini untuk alamat api/auth/register
    Route::post('login', [LoginController::class, 'login']);
    Route::post('coba', [LoginController::class, 'coba']);      

});

// profile 
Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::put('/me/update/{user}', [MeController::class, 'update']);
    Route::post('/me/upload_image/{user}', [MeController::class, 'upload_image']);
    Route::post('/prokc/sw-token', [MeController::class, 'swToken']);
});