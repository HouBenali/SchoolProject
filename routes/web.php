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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [App\Http\Controller\Web\WebController::class,'index']);

Route::get('/pokedex', [App\Http\Controllers\web\WebController::class, 'index'])->name('pokemons');
Route::get('/', [App\Http\Controllers\web\WebController::class, 'index'])->name('index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/starting', [App\Http\Controllers\HomeController::class, 'index'])->name('starting');
Route::get('/Bulbasaur', [App\Http\Controllers\HomeController::class, 'index'])->name('tutorial');
Route::get('/Squirtle', [App\Http\Controllers\HomeController::class, 'index'])->name('tutorial');
Route::get('/Charmander', [App\Http\Controllers\HomeController::class, 'index'])->name('tutorial');
Route::get('/adventure', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/online', [App\Http\Controllers\WebController::class, 'index']);
Route::get('/wildMap/{area}', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/profile', [App\Http\Controllers\web\WebController::class, 'index'])->name('profile');
Route::get('/shop', [App\Http\Controllers\web\WebController::class, 'index'])->name('shop');
Route::get('/myshops', [App\Http\Controllers\web\WebController::class, 'index'])->name('myshops');
Route::get('/myGamesOff', [App\Http\Controllers\web\WebController::class, 'index'])->name('myshops');
Route::get('/decks', [App\Http\Controllers\web\WebController::class, 'index'])->name('myshops');
Route::get('/changeAvatar', [App\Http\Controllers\web\WebController::class, 'index'])->name('avatar');
Route::get('/changePass', [App\Http\Controllers\web\WebController::class, 'index'])->name('changePass');
Route::get('/changeProfile', [App\Http\Controllers\web\WebController::class, 'index'])->name('changeProfile');


Auth::routes();

Route::get('register', [App\Http\Controllers\web\WebController::class, 'index'])->name('register');
Route::get('login', [App\Http\Controllers\web\WebController::class, 'index'])->name('login');
Route::post('forgot', [App\Http\Controllers\ForgotController::class, 'forgot'])->name('forgot');
Route::get('forgot', [App\Http\Controllers\ForgotController::class, 'forgot'])->name('forgot');

Route::post('/reset', [App\Http\Controllers\ForgotController::class, 'reset'])->name('reset');
Route::get('reset/{token?}', [App\Http\Controllers\web\WebController::class, 'index'])->name('reset');
