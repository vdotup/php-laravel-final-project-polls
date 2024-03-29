<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PollController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     redirect('home');
// })->middleware('auth');

Route::get('/', [PollController::class, 'index'])->name('home')->middleware('auth');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/index', [PollController::class, 'index'])->name('index');

Route::resource('polls', PollController::class)->middleware('auth');

Route::put('/polls/{poll}', [PollController::class, 'update'])->name('polls.update');
Route::get('polls/{token}/share', [PollController::class, 'share'])->name('polls.share');
Route::post('polls/{token}/vote', [PollController::class, 'vote'])->name('polls.vote');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
