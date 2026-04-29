<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('/debug-kubikasi', function () {
    return view('debug-kubikasi');
});
