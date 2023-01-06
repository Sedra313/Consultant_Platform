<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Models\Expert;

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

Route::post('expert/register'   ,   [AuthController::class ,'Expert_Register']);
Route::post('expert/login'   ,      [AuthController::class ,'Expert_Login']);
Route::post('expert/businesstimes'   ,[AuthController::class ,'Expert_Set_Times']);
Route::get('/categories',[CategoryController::class, 'index']);
Route::get('categories',[CategoryController::class, 'index']);
//Route::get('search',[SearchController::class, 'search']);




Route::group( ['prefix' => 'expert','middleware' => ['auth:expert-api','scopes:expert'] ], function(){
       Route::post('update',[AuthController::class, 'Expert_Update']);
       Route::post('logout',[AuthController::class, 'Expert_Logout']);
});