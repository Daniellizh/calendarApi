<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CalendarController;
use App\Http\Controllers\Auth\ApiAuthController;


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

    Route::post('register', [ApiAuthController::class, 'register']);
    Route::post('login', [ApiAuthController::class, 'login']);
    
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('calendar', [CalendarController::class, 'index']);
    Route::patch('calendar/{event}', [CalendarController::class,'update']);
    Route::delete('calendar/{event}', [CalendarController::class,'destroy']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});

    Route::post('calendar', [CalendarController::class, 'store']);