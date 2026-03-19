<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::resource('projects', \App\Http\Controllers\ProjectController::class)
    ->names('project');
Route::get('/projects/featured', [\App\Http\Controllers\ProjectController::class, 'featured'])
    ->name('projects.featured');
Route::get('/projects/featured/image.webp', [\App\Http\Controllers\ProjectController::class, 'featuredImage'])
    ->name('projects.featured.image');
Route::get('/projects/{project}/image.webp', [\App\Http\Controllers\ProjectController::class, 'image'])
    ->name('project.image');

Route::resource('hosts', \App\Http\Controllers\HostController::class)
    ->names('host');

Route::match(['get', 'post'], '/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])
    ->name('auth.login');
