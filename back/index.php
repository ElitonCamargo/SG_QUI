<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Controller\Elemento;

require __DIR__ . '/vendor/autoload.php';
require_once 'App/helpers/autoload.php';


$app = AppFactory::create();
$app->setBasePath('/back'); // Define o caminho base do aplicativo


$app->add(function (Request $request, $handler) { // Define o middleware para transformar a resposta em JSON
    $response = $handler->handle($request);
    return $response->withHeader('Content-Type', 'application/json');
});

$elemento = new Elemento();
$app->get('/elemento', function(Request $req, Response $res, $args)use ($elemento){
        return $elemento->listarTodos($req,$res,$args);
    }
); 
$app->get('/elemento/{id}', function(Request $req, Response $res, $args)use ($elemento){
        return $elemento->listarPorId($req,$res,$args);
    }
); 
$app->get('/elemento/{buscar}/{por}', function(Request $req, Response $res, $args)
    use ($elemento){
        return $elemento->listarPor($req,$res,$args);
    }    
); 

require_once 'app/helpers/rota_nao_encontrada.php';

$app->run();
