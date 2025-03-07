<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::get('/projects/featured', [\App\Http\Controllers\ProjectController::class, 'featured'])
    ->name('projects.featured');
Route::get('/projects/featured/image.webp', [\App\Http\Controllers\ProjectController::class, 'featuredImage'])
    ->name('projects.featured.image');
Route::get('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'show'])
    ->name('project.show');
Route::get('/projects/{project}/image.webp', [\App\Http\Controllers\ProjectController::class, 'image'])
    ->name('project.image');
