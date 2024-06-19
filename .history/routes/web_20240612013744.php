<?php

use App\Http\Controllers\KundeController;
use App\Http\Controllers\RechnungController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Hash;
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
Route::get('/troni', function(){
   dd(Hash::make('your_super_strong_password_here'));
});

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

// Stats Routes - only for loggedin user
Route::middleware(['auth:sanctum', 'verified'])->get('/stats', [StatsController::class, 'index'])->name('allstats');

// selbstauskunft
Route::middleware(['auth:sanctum', 'verified'])->get('/selbstauskunfte', [App\Http\Controllers\SelbstauskunftController::class, 'index'])->name('selbstauskunftindex');
Route::middleware(['auth:sanctum', 'verified'])->get('/selbstauskunfte/{id}', [App\Http\Controllers\SelbstauskunftController::class, 'show'])->name('selbstauskunftshow');


// Rechnung Routes - only for loggedin user
Route::middleware(['auth:sanctum', 'verified'])->get('/rechnung', [App\Http\Controllers\RechnungController::class, 'index'])->name('rechnungenindex');
Route::middleware(['auth:sanctum', 'verified'])->get('/rechnung/{id}', [App\Http\Controllers\RechnungController::class, 'show'])->name('rechnungenshow');
Route::middleware(['auth:sanctum', 'verified'])->post('/allesrechnungen', [App\Http\Controllers\RechnungController::class, 'dayrechnungen'])->name('allesrechnungens');
Route::middleware(['auth:sanctum', 'verified'])->post('/rechnungdownload', [App\Http\Controllers\RechnungController::class, 'rechnungdownload'])->name('rechnungdownload');
Route::middleware(['auth:sanctum', 'verified'])->get('/allerechnungen', [App\Http\Controllers\RechnungController::class, 'alles'])->name('allerechnungens');
//
Route::middleware(['auth:sanctum', 'verified'])->get('/sign', function(){

    return view('kunde/signature');
} );
Route::get('/armendtest', [App\Http\Controllers\KundeController::class, 'armend']);
// Show all test without ergebnis
Route::middleware(['auth:sanctum', 'verified'])->get('/inwartezeit', [App\Http\Controllers\TestController::class, 'inWarteZeit'])->name('inwartezeit');
//Route::middleware(['auth:sanctum', 'verified'])->get('/import', [App\Http\Controllers\KundeController::class, 'import'])->name('import');
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


