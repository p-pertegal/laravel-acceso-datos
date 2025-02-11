<?php

use Illuminate\Support\Facades\Route;

route::view('/students', 'students');

Route::get('/', function () {
    return view('welcome');
});
