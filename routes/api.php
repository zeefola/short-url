<?php

use App\Http\Controllers\ShortUrlController;
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

Route::group(['prefix' => 'url'], function () {
    Route::get('/short', [ShortUrlController::class, 'index']);
    Route::post('/generate', [ShortUrlController::class, 'generateUrl']);


    Route::get('/{url}', [ShortUrlController::class, 'shortenUrl']);
});