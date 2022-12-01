<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
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
    return $request->user();
});

Route::post('login',[ApiController::class,'login']);
Route::post('register',[ApiController::class,'register'] );


Route::group(["middleware" => ["auth:api"]], function(){
    
    Route::get('getAuthUser',[ApiController::class,'getAuthUser'] );

    Route::apiResource('user',UserController::class);
    Route::apiResource('book',BookController::class);

    Route::post('book_issue',[BookController::class,'book_issue'] );
    Route::post('return_book/{id}',[BookController::class,'return_book'] );
    Route::get('Userwise_rented',[BookController::class,'Userwise_rented'] );
   
    
    });