<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');
Route::inertia('/about', 'About')->name('about');
Route::inertia('/skills', 'Skills')->name('skills');
Route::inertia('/work', 'Work')->name('work');
Route::inertia('/blog', 'Blog')->name('blog');
