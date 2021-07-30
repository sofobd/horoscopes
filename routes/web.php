<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\HoroscopesController;

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

Route::get('/', 'HoroscopesController@index')->name('index');
Route::post('/horoscopes/calendar', 'HoroscopesController@calendar')->name('horoscopes.calendar');
Route::post('/horoscopes/calendar/best/month', 'HoroscopesController@best_month_calendar')->name('horoscopes.best_month');
Route::post('/horoscopes/best/sign', 'HoroscopesController@best_of_year')->name('best.zodiac.sign');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//custom route
//Route::get('/horoscopes/generate', [HoroscopesController::class,'generate'])->middleware(['auth'])->name('horoscopes-generate');
Route::get('/horoscopes/generate', 'HoroscopesController@generate')->middleware(['auth'])->name('horoscopes.generate');
Route::post('/horoscopes/store', 'HoroscopesController@store')->middleware(['auth'])->name('horoscopes.store');

require __DIR__.'/auth.php';
