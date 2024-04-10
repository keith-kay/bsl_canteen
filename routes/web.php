<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MealSelectionController;

// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/register-user', [UserController::class, 'register'])->name('register-user');
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::get('/', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login-user');
Route::post('/selectMeal', [MealSelectionController::class, 'selectMeal'])
    ->middleware('auth')
    ->name("select-meal");
Route::get('/logout', [UserController::class, 'logout'])
    ->name('logout');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name("dashboard");
