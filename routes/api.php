<?php

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
Route::post('register',[\App\Http\Controllers\Authentication::class, 'register']);
Route::post('logIn',[\App\Http\Controllers\Authentication::class, 'logIn'])->middleware('isVerified');
Route::post('verifyUser',[\App\Http\Controllers\Authentication::class, 'verifyCode']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group( function () {
    Route::get('getTags',[\App\Http\Controllers\tags::class, 'getAllTags']);
    Route::post('createTag',[\App\Http\Controllers\tags::class, 'createTag']);
    Route::post('updateTag',[\App\Http\Controllers\tags::class, 'updateTag']);
    Route::post('deleteTag',[\App\Http\Controllers\tags::class, 'deleteTag']);
    Route::get('getUserPosts',[\App\Http\Controllers\posts::class, 'getUserPosts']);
    Route::post('createPost',[\App\Http\Controllers\posts::class, 'createPost']);
    Route::get('getSinglePost',[\App\Http\Controllers\posts::class, 'getSinglePost']);
    Route::get('deletePost',[\App\Http\Controllers\posts::class, 'deletePost']);
    Route::get('showDeletedPosts',[\App\Http\Controllers\posts::class, 'showDeletedPosts']);
    Route::get('restoreSingleDeletedPost',[\App\Http\Controllers\posts::class, 'restoreSingleDeletedPost']);
    Route::post('update',[\App\Http\Controllers\posts::class, 'update']);

});
Route::get('getData',[\App\Http\Controllers\state::class, 'getData']);
