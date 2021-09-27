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
    return view('home');
});

Route::get('/input', function () {
    return view('input');
})->name('input');

use App\Http\Controllers\TranslateController;
Route::post('/input/translate',[TranslateController::class, 'translate' ]) -> name('file_analyzes');

Route::get('/input/output', function () {
    return view('output');
})->name('file_output');