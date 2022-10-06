<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\ProductController;

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

    Route::get('/ping', [HomeController::class, 'ping']);

    // Rota inicial para exibir "Fullstack Challenge 20201026" - requisito do desafio.
    Route::get('/', [HomeController::class, 'index']);

    // Rota para listar todos os produtos cadastrados no Banco de Dados.
    Route::get('/products', [ProductController::class, 'index']);

    // Rota para buscar produtos no Banco de Dados pelo código de barras.
    Route::get('/products/sync', [ProductController::class, 'sync']);
    Route::get('/product/{barCode}', [ProductController::class, 'findByBarCode']);

    // Rota responsável por sincronizar manualmente os produtos do site "OpenFoodFacts" com o banco de dados.

    Route::get('/products/sync', [ProductController::class, 'sync']);
