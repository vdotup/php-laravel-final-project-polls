<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PollController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/index', function () {
//     return view('index');
// })->name('index');;

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/index', [PollController::class, 'index'])->name('index');

Route::resource('polls', PollController::class)->middleware('auth');

Route::get('polls/{poll}/share', [PollController::class, 'share'])->name('polls.share');
Route::post('polls/{poll}/vote', [PollController::class, 'vote'])->name('polls.vote');