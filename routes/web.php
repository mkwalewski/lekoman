<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes...
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Custom Routes...
Route::get('/', [App\Http\Controllers\MedicinesController::class, 'index'])->name('dashboard');
Route::get('/medicines/list', [App\Http\Controllers\MedicinesController::class, 'list'])->name('medicines.list');
Route::get('/medicines/dose', [App\Http\Controllers\MedicinesController::class, 'dose'])->name('medicines.dose');
Route::match(['get', 'post'], '/medicines/dose/update/{id}', [App\Http\Controllers\MedicinesController::class, 'doseUpdate'])->name('medicines.dose.update');
Route::delete('/medicines/dose/delete/{id}', [App\Http\Controllers\MedicinesController::class, 'doseDelete'])->name('medicines.dose.delete');
Route::match(['get', 'post'],'/medicines/take', [App\Http\Controllers\MedicinesController::class, 'take'])->name('medicines.take');
Route::post('/moods', [App\Http\Controllers\MedicinesController::class, 'moods'])->name('medicines.moods');
Route::get('/moods/history', [App\Http\Controllers\MedicinesController::class, 'moodsHistory'])->name('medicines.moods.history');
Route::delete('/moods/history/delete/{id}', [App\Http\Controllers\MedicinesController::class, 'moodsHistoryDelete'])->name('medicines.moods.history.delete');
Route::get('/medicines/history', [App\Http\Controllers\MedicinesController::class, 'history'])->name('medicines.history');
Route::delete('/medicines/history/delete/{id}', [App\Http\Controllers\MedicinesController::class, 'historyDelete'])->name('medicines.history.delete');
Route::get('/medicines/charts', [App\Http\Controllers\MedicinesController::class, 'charts'])->name('medicines.charts');
Route::match(['get', 'post'],'/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
Route::get('/notifications/list', [App\Http\Controllers\NotificationsController::class, 'list'])->name('notifications.list');
Route::match(['get', 'post'], '/notifications/update/{id}', [App\Http\Controllers\NotificationsController::class, 'update'])->name('notifications.update');
Route::delete('/notifications/delete/{id}', [App\Http\Controllers\NotificationsController::class, 'delete'])->name('notifications.delete');
