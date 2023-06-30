<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormsController;
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

Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class,'register']);
Route::post('verify',[UserController::class,'verify']);
Route::post('send_code',[UserController::class,'send_code']);



Route::resource('forms', FormsController::class);
Route::get('publish_form/{id}', [FormsController::class,'publish_form']);
Route::get('export_answers', [FormsController::class,'export_answers']);
