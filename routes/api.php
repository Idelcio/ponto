<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui você pode registrar rotas da API para sua aplicação. Essas rotas
| são carregadas pelo RouteServiceProvider e todas elas serão atribuídas
| ao grupo de middleware "api". Aproveite!
|
*/

Route::middleware('api')->get('/ping', function () {
    return response()->json(['status' => 'ok']);
});
