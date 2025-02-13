<?php

use Illumninate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AeronaveController;
use App\Http\Controllers\Api\FabricanteController;

Route::apiResource('aeronaves', AeronaveController::class);
Route::apiResource('fabricantes', FabricanteController::class);
Route::get('/user', function (Request $request) {
	return $request->user();
});
