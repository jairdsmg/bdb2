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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->middleware('jwt.auth')->group(function(){
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::apiResource('cliente', 'App\Http\Controllers\ClienteController');
    Route::apiResource('categoria', 'App\Http\Controllers\CategoriaController');
    Route::apiResource('fabricante', 'App\Http\Controllers\FabricanteController');
    Route::apiResource('lista', 'App\Http\Controllers\ListaController');
    Route::apiResource('loja', 'App\Http\Controllers\LojaController');
    Route::apiResource('marca', 'App\Http\Controllers\MarcaController');
    Route::apiResource('preco', 'App\Http\Controllers\PrecoController');
    Route::apiResource('produto', 'App\Http\Controllers\ProdutoController');
    Route::apiResource('rede', 'App\Http\Controllers\RedeController');
    Route::apiResource('produtoLista', 'App\Http\Controllers\ProdutoListaController');
    Route::apiResource('endereco', 'App\Http\Controllers\EnderecoController');

});



Route::post('login', 'App\Http\Controllers\AuthController@login');




