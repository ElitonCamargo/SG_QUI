<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
require_once 'app/database/BaseDeDados.php';
require_once 'app/Model/Elemento.php';
use App\Model\Elemento;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('/back'); // Define o caminho base do aplicativo


$app->add(function (Request $request, $handler) { // Define o middleware para transformar a resposta em JSON
    $response = $handler->handle($request);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/elemento', function (Request $request, Response $response, $args) {
   
    // $elemento = new Elemento();
    // $result = $elemento->consultarTodos();
    $result = $args;
    $response->getBody()->write(json_encode($result));
    return $response;
});

$app->get('/elemento/{id}', function (Request $request, Response $response, $args) {
   
    // $elemento = new Elemento();
    // $result = $elemento->consultarTodos();
    $result = $args;
    $response->getBody()->write(json_encode($result));
    return $response;
});

$app->get('/elemento/{buscar}/{por}', function (Request $req, Response $res, $args) {
   
    // $elemento = new Elemento();
    // $result = $elemento->consultarTodos();
    $result = [
        'args' => $args,
        'req' => $req->getQueryParams()
    ];

    $res->getBody()->write(json_encode($result));
    return $res;
});





// $app->get('/categoria', function (Request $request, Response $response, $args) {
//     $categorias = [
//         ['id' => 1, 'name' => 'Brinquedos'],
//         ['id' => 2, 'name' => 'Doces']
//     ];
//     $response->getBody()->write(json_encode($categorias));
//     return $response;
// });

// $app->get('/usuario', function (Request $request, Response $response, $args) {
//     $categorias = [
//         ['id' => 1, 'name' => 'Eliton'],
//         ['id' => 2, 'name' => 'José']
//     ];
//     $response->getBody()->write(json_encode($categorias));
//     return $response;
// });
// $app->get('/usuario/{login}/{id}', function (Request $request, Response $response, $args) {
//     $categorias = [
//         ['id' => 1, 'name' => 'Eliton']
//     ];
//     $response->getBody()->write(json_encode($categorias));
//     return $response;
// });

// $app->get('/usuario/{login}', function (Request $request, Response $response, $args) {
//     $categorias = [
//         ['id' => 1, 'name' => 'Fernando']
//     ];
//     $response->getBody()->write(json_encode($categorias));
//     return $response;
// });

require_once 'app/helpers/rota_nao_encontrada.php';

$app->run();
