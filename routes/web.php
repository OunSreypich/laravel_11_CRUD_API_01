<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\NoteController;

Route::get('/h', function () {
    return view('welcome');
});

// simple route 
Route::get('/crush', [WelcomeController::class, 'welcome'])->name('welcome');
Route::get('/note', [NoteController::class, 'index'])->name('note');

// resource route
Route::resource('postcrush', 'App\Http\Controllers\PostController');
