<?php

use Illumninate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AeronaveController;

Route::apiResource('aeronaves', AeronaveController::class);
Route::get('/user', function (Request $request) {
	return $request->user();
});
