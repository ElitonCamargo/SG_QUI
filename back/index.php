<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
// 
require __DIR__ . '/vendor/autoload.php';
// 
$app = AppFactory::create();
$app->setBasePath('/back'); // Define o caminho base do aplicativo
// 
// Define o middleware para transformar a resposta em JSON
$app->add(function (Request $request, $handler) {
    $response = $handler->handle($request);
    return $response->withHeader('Content-Type', 'application/json');
});
// 
// Rotas e lógica da aplicação
// 
$app->get('/produto', function (Request $request, Response $response, $args) {
    $produtos = [
        ['id' => 1, 'name' => 'Bola'],
        ['id' => 2, 'name' => 'Bala']
    ];
    $response->getBody()->write(json_encode($produtos));
    return $response;
});
$app->get('/categoria', function (Request $request, Response $response, $args) {
    $categorias = [
        ['id' => 1, 'name' => 'Brinquedos'],
        ['id' => 2, 'name' => 'Doces']
    ];
    $response->getBody()->write(json_encode($categorias));
    return $response;
});
// 
$app->get('/usuario', function (Request $request, Response $response, $args) {
    $categorias = [
        ['id' => 1, 'name' => 'Eliton'],
        ['id' => 2, 'name' => 'José']
    ];
    $response->getBody()->write(json_encode($categorias));
    return $response;
});
$app->get('/usuario/{login}/{id}', function (Request $request, Response $response, $args) {
    $categorias = [
        ['id' => 1, 'name' => 'Eliton']
    ];
    $response->getBody()->write(json_encode($categorias));
    return $response;
});

$app->get('/usuario/{login}', function (Request $request, Response $response, $args) {
    $categorias = [
        ['id' => 1, 'name' => 'Fernando']
    ];
    $response->getBody()->write(json_encode($categorias));
    return $response;
});

require_once 'src/recursos/rota_nao_encontrada.php';

$app->run();
