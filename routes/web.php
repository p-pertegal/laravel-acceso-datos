<?php

use Illuminate\Support\Facades\Route;

route::view('/aeronaves', 'aeronaves');

Route::get('/', function () {
    return view('welcome');
});
