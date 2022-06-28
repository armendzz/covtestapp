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
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

// Kunde routes - only for loggedin user 
Route::resource('kunde', KundeController::class, [
    'names' => [
        'index' => 'kunde-suchen',
        'create' => 'kunde-create',
        ]])->middleware('auth');

// Test Routes - only for loggedin user 
Route::resource('tests', TestController::class, [
    'names' => [
        'index' => 'test-suchen',
        ]])->middleware('auth');
//
Route::get('/armendtest', [App\Http\Controllers\KundeController::class, 'armend']);
// Show all test without ergebnis
Route::middleware(['auth:sanctum', 'verified'])->get('/inwartezeit', [App\Http\Controllers\TestController::class, 'inWarteZeit'])->name('inwartezeit');

// Route for Setting result and Print or send in email result
Route::middleware(['auth:sanctum', 'verified'])->put('/test-ergebnis/{id}', [App\Http\Controllers\TestController::class, 'testErgebnis'])->name('testergebnis');

// Route for resend email with new data or if something went wrong
Route::middleware(['auth:sanctum', 'verified'])->post('/emailerneutsenden/{id}', [App\Http\Controllers\TestController::class, 'emailErneutSenden'])->name('emailerneutsenden');

// send info email for postivie kunden
Route::middleware(['auth:sanctum', 'verified'])->post('/infomailpositiv/{id}', [App\Http\Controllers\TestController::class, 'infoMailPositiv'])->name('infoMailPositiv');

// Show all positive result
Route::middleware(['auth:sanctum', 'verified'])->get('/positive', [App\Http\Controllers\TestController::class, 'positive'])->name('positiv');

// Positive tests fill form to send to gesundheitsamt
Route::middleware(['auth:sanctum', 'verified'])->get('/positiveform/{id}', [App\Http\Controllers\TestController::class, 'positiveForm']);

// Prepare Positive tests for sending to geseundheitsamt 
Route::middleware(['auth:sanctum', 'verified'])->post('/positiveformprepare/{id}', [App\Http\Controllers\TestController::class, 'positiveFormPrepare']);

// Send fullyfilled pdf to gesundheitsamt
Route::middleware(['auth:sanctum', 'verified'])->put('/positiveformsend/{id}', [App\Http\Controllers\TestController::class, 'positiveFormSend']);

// send all inexistent routes to dashboard or in login page if user is not logged in 
Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return redirect('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/{any}', function () {
    return redirect('dashboard');
});


