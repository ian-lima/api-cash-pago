<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usuario;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Endpoints criados para API
Route::post('/logar', [Usuario::class, 'logar']);
Route::post('/criarUsuario', [Usuario::class, 'criar']);

// Criar rota para fazer logout

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/listarTodosUsuarios', [Usuario::class, 'listarTudo']);
    Route::get('/listarUsuario/{Id}', [Usuario::class, 'listar']);
    Route::delete('/deletarUsuario/{Id}', [Usuario::class, 'deletar']);
    
});