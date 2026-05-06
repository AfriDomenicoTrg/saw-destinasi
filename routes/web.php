<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WisataController;

Route::get('/', function () {
    return view('auth.login');
});

