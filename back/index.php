<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Controller\Elemento;
use App\Controller\Composto_qui;

require __DIR__ . '/vendor/autoload.php';
require_once 'App/helpers/autoload.php';
require_once 'app/helpers/funcoes.php';


$app = AppFactory::create();
$app->setBasePath('/back'); // Define o caminho base do aplicativo


$app->add(function (Request $request, $handler) { // Define o middleware para transformar a resposta em JSON
    $response = $handler->handle($request);
    return $response->withHeader('Content-Type', 'application/json');
});
// *************************** Elemento ***************************
// GET
    $elemento = new Elemento();
    $app->get('/elemento', function(Request $req, Response $res, $args)use ($elemento){
            return $elemento->listarTodos($req,$res,$args);
        }
    ); 
    $app->get('/elemento/{id}', function(Request $req, Response $res, $args)use ($elemento){
            return $elemento->listarPorId($req,$res,$args);
        }
    );

// *************************** Composto_qui ***************************
// GET
    $composto_qui = new Composto_qui();
    $app->get('/composto_qui', function(Request $req, Response $res, $args) use ($composto_qui){
        return $composto_qui->listarTodos($req,$res,$args);
    }); 

    $app->get('/composto_qui/{id}', function(Request $req, Response $res, $args) use ($composto_qui){
        return $composto_qui->listarPorId($req,$res,$args);
    }); 
// POST
    $app->post('/composto_qui', function(Request $req, Response $res, $args) use ($composto_qui){
        return $composto_qui->cadastrar($req,$res,$args);
    });
// DELETE
    $app->delete('/composto_qui/{id}', function(Request $req, Response $res, $args) use ($composto_qui){
        return $composto_qui->delete($req,$res,$args);
    });
// Alterar
    $app->put('/composto_qui/{id}', function(Request $req, Response $res, $args) use ($composto_qui){
        return $composto_qui->alterar($req,$res,$args);
    });    
    $app->patch('/composto_qui/{id}', function(Request $req, Response $res, $args) use ($composto_qui){
        return $composto_qui->alteracao_seletiva($req,$res,$args);
    });

require_once 'app/helpers/rota_nao_encontrada.php';

$app->run();
