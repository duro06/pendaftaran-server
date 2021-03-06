<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\MeController;
use App\Http\Controllers\API\BioController;
use App\Http\Controllers\API\MediaController;
use App\Http\Controllers\API\NilaiController;
use App\Http\Controllers\API\ForumController;
use App\Http\Controllers\API\PendaftaranController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\BerkasController;
use App\Http\Controllers\API\SekolahController;


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
    $user=$request->user();
    $user->load('nilai.mapel');
    $user->load('bio');
    $user->load('media.type');
    return ['data'=>$user];
});
//public
Route::get('admin/sekolah/get-sekolah',[SekolahController::class, 'index']);	
// Auth
Route::group(['prefix' => '/auth'], function() {
    Route::group(['middleware'=>'auth:sanctum'], function(){
        Route::get('logout', [LoginController::class, 'logout']);
    });

    Route::post('register', [RegisterController::class, 'register']); // ini untuk alamat api/auth/register
    Route::post('login', [LoginController::class, 'login']);
    Route::post('coba', [LoginController::class, 'coba']);

});

Route::group(['middleware'=>'auth:sanctum'], function(){
    // profile 
    Route::put('/me/update/{user}', [MeController::class, 'update']);
    Route::post('/me/upload_image/{user}', [MeController::class, 'upload_image']);
    Route::post('/prokc/sw-token', [MeController::class, 'swToken']);
    
    //forums
    Route::post('forum/add_message',[ForumController::class, 'add_message']);
    Route::get('forum/get_chat',[ForumController::class, 'get_chat']);
    Route::get('forum/get_user',[ForumController::class, 'get_user']);
    
    //Bio
    Route::get('bio',[BioController::class, 'index']);
    Route::put('bio/update/{bio}',[BioController::class, 'update']);
    Route::post('bio/store',[BioController::class, 'store']);
    Route::post('bio/upload_image/{bio}', [BioController::class, 'upload_image']);
    
    // mapel dan Nilai
    Route::get('mapel',[NilaiController::class, 'index']);
    
    Route::get('nilai/nilai_by',[NilaiController::class, 'nilai_by']);
    Route::get('nilai/media_by',[NilaiController::class, 'media_by']);
    Route::post('nilai',[NilaiController::class, 'store']);
    Route::post('nilai/update/{nilai}',[NilaiController::class, 'update']);
    
    Route::get('type',[NilaiController::class, 'type']);
    // Route::post('type/upload_image/{media}',[MediaController::class, 'upload_image']);
    Route::post('type/upload_image',[MediaController::class, 'upload_image']);
    
    //pendaftaran
    Route::get('daftar',[PendaftaranController::class, 'index']);
    Route::get('daftar/peserta',[PendaftaranController::class, 'peserta']);
    Route::post('daftar/daftar_peserta',[PendaftaranController::class, 'daftar_peserta']);
    
    // admin 
    Route::get('admin/test-fcm',[AdminController::class, 'testFcm']);
    
    Route::post('admin/mapel/add',[AdminController::class, 'add_mapel']);
    Route::post('admin/mapel/edit',[AdminController::class, 'edit_mapel']);
    Route::post('admin/mapel/delete',[AdminController::class, 'delete_mapel']);
    Route::post('admin/type/add',[AdminController::class, 'add_type']);
    Route::post('admin/type/edit',[AdminController::class, 'edit_type']);
    Route::post('admin/type/delete',[AdminController::class, 'delete_type']);
    
    Route::get('admin/inactive_pendaftaran',[PendaftaranController::class, 'inactive_pendaftaran']);
    Route::post('admin/add_pendaftaran',[PendaftaranController::class, 'add_pendaftaran']);
    Route::post('admin/edit_pendaftaran',[PendaftaranController::class, 'edit_pendaftaran']);
    Route::post('admin/hapus_pendaftaran',[PendaftaranController::class, 'hapus_pendaftaran']);
    Route::post('admin/restore_pendaftaran',[PendaftaranController::class, 'restore_pendaftaran']);
    
    Route::get('admin/berkas',[BerkasController::class, 'get_all']);
    Route::get('admin/berkas/by_id',[BerkasController::class, 'get_by_id']);
    Route::post('admin/berkas/status_change',[BerkasController::class, 'status_change']);
    
    
    Route::post('admin/sekolah/store',[SekolahController::class, 'store']);
    
    Route::post('sekolah/upload_image/{sekolah}',[SekolahController::class, 'upload_image']);
});