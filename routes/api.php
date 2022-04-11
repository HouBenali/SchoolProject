<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource("pokemons", 'App\Http\Controllers\PokemonController');
    Route::apiResource('users', 'App\Http\Controllers\UserController');
    Route::apiResource("games", 'App\Http\Controllers\GameController');
    Route::apiResource("gamesOffline", 'App\Http\Controllers\OfflineController');
});
*/

//Peticion para actualizar los precios de los pokemon
//Route::get('pricePoke', [App\Http\Controllers\api\PokedexController::class,'pricePoke']); //UPDATE PRICE_POKEMONS

Route::post('user/restarPrice', [App\Http\Controllers\UserController::class,'restar_price']);
Route::post('user/sumarPrice', [App\Http\Controllers\UserController::class,'sumar_price']);

Route::get('user/getMyShops', [App\Http\Controllers\api\MyShopController::class,'getMyShops']);
Route::get('user/getGamesOff', [App\Http\Controllers\api\GamesOfflineController::class,'getGamesOff']);

Route::get('pokesUser',[App\Http\Controllers\UserController::class, 'pokesUser'])->name('pokesUser');

Route::post('cart/addpoke',[App\Http\Controllers\api\CartController::class, 'addPoke'])->name('addPoke');
Route::post('cart/delpoke',[App\Http\Controllers\api\CartController::class, 'delPoke'])->name('delPoke');
Route::get('cart/getCart',[App\Http\Controllers\api\CartController::class, 'getCart'])->name('getCart');
Route::post('savePoke', [App\Http\Controllers\api\CartController::class,'save_poke'])->name('savePoke');

Route::post('setRewards',[App\Http\Controllers\UserController::class, 'setRewards'])->name('setRewards');
Route::post('setCookie',[App\Http\Controllers\UserController::class, 'setCookie'])->name('setCookie');
Route::post('hasPokes',[App\Http\Controllers\UserController::class, 'hasPokes'])->name('hasPokes');

Route::post('setPokemon/{id}',[App\Http\Controllers\UserController::class, 'setPokemon'])->name('setPokemon');
Route::post('/reset/{token}', [App\Http\Controllers\ForgotController::class, 'reset'])->name('reset');

Route::post('getPokemonByID/{id}',[App\Http\Controllers\api\PokedexController::class, 'getPokemonByID'])->name('getPokemonByID');
Route::resource('pokemon', App\Http\Controllers\api\PokedexController::class)->only(['index','show','store'])->middleware('auth:sanctum');

Route::post('forgot', [App\Http\Controllers\ForgotController::class, 'forgot'])->name('forgot');
Route::post('register', [App\Http\Controllers\api\RegisterController::class,'store']);

Route::get('getAvatar',[App\Http\Controllers\api\AvatarController::class,'get']);
Route::post('updateAvatar',[App\Http\Controllers\api\AvatarController::class,'update']);

Route::post('/updateNick', [App\Http\Controllers\api\ChangeController::class, 'updateNick'])->name('updateNick');
Route::post('/updateEmail', [App\Http\Controllers\api\ChangeController::class, 'updateEmail'])->name('updateEmail');
Route::post('/changePass', [App\Http\Controllers\api\ChangeController::class, 'reset'])->name('changePass');

Route::post('/changeMainDeck', [App\Http\Controllers\DeckController::class, 'changeMainDeck']);
Route::get('/isMainDeck', [App\Http\Controllers\DeckController::class, 'isMainDeck']);
Route::get('/getMainDeck', [App\Http\Controllers\DeckController::class, 'getMainDeck']);
Route::get('/getDeck/{id}', [App\Http\Controllers\DeckController::class, 'getDeck']);
Route::get('/getDecks', [App\Http\Controllers\DeckController::class, 'getDecks']);
Route::post('/deleteDeck', [App\Http\Controllers\DeckController::class, 'deleteDeck']);
Route::post('/createDeck', [App\Http\Controllers\DeckController::class, 'createDeck']);
Route::post('/renameDeck', [App\Http\Controllers\DeckController::class, 'renameDeck']);
Route::post('/addPokeDeck', [App\Http\Controllers\DeckController::class, 'addPokeDeck']);
Route::post('/dropPokeDeck', [App\Http\Controllers\DeckController::class, 'dropPokeDeck']);