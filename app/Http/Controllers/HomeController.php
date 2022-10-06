<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @OA\Post(
     *      path="/",
     *      operationId="",
     *      tags={"Home"},
     *      summary="Exibe o texto 'Fullstack Challenge 20201026'.",
     *      description="Essa rota exibe o texto 'Fullstack Challenge 20201026'.",
     *      @OA\Response(
     *          response=200,
     *          description="Fullstack Challenge 20201026"
     *       )
     *     )
     *
     * Retorna o texto 'Fullstack Challenge 20201026'
     */
    public function index() {
        return "Fullstack Challenge 20201026";
    }


    /**
     * @OA\Post(
     *      path="/ping",
     *      operationId="ping",
     *      tags={"Ping"},
     *      summary="Testa se a API está funcionando.",
     *      description="Essa rota faz simples teste de resposta para saber se a API está rodando normalmente.",
     *      @OA\Response(
     *          response=200,
     *          description="Ping & Pong"
     *       )
     *     )
     *
     * Retorna /pong se tiver tudo ok'
     */
    public function ping() {
        return "pong";
    }
}
