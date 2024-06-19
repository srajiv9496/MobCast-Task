<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
