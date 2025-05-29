<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CourseController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\AuthController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{id}', [CourseController::class, 'show']);

Route::get('/Category', [CategoryController::class, 'index']);
Route::get('/Category/{id}', [CategoryController::class, 'show']);