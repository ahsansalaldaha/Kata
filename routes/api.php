<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\ShopTimingController;
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


Route::apiResource('schedule', ScheduleController::class);

Route::get('/is-open-now', [
    ShopTimingController::class,
    'isOpenNow',
]);

Route::get('/is-open-on', [
    ShopTimingController::class,
    'isOpenOn',
]);

Route::get('/nearest-open-date', [
    ShopTimingController::class,
    'nearestOpenDate',
]);
