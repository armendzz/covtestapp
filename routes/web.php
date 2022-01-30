<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KundeController;
use App\Http\Controllers\TestController;

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

// Dashboard route - only for loggedin user !!
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Kunde routes - only for loggedin user 
Route::resource('kunde', KundeController::class)->middleware('auth');

// Test Routes - only for loggedin user 
Route::resource('tests', TestController::class)->middleware('auth');

// Show all test without ergebnis
Route::middleware(['auth:sanctum', 'verified'])->get('/inwartezeit', [App\Http\Controllers\TestController::class, 'inWarteZeit'])->name('inwartezeit');

// Route for Setting result and Print or send in email result
Route::middleware(['auth:sanctum', 'verified'])->put('/test-ergebnis/{id}', [App\Http\Controllers\TestController::class, 'testErgebnis'])->name('testergebnis');

// send all inexistent routes to dashboard or in login page if user is not logged in 
Route::middleware(['auth:sanctum', 'verified'])->get('/{any}', function () {
    return view('dashboard');
});


