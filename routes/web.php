<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;  //to call PostController to be used and it must have namespace



Route::get('/', function () {
    return view('welcome');
});



