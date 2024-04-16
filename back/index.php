<?php

use app\database\Conexao;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




// use Psr\Http\Message\ServerRequestInterface as Request;
// use Slim\Factory\AppFactory;


// require __DIR__ . '/vendor/autoload.php';
// require_once 'app/helpers/funcoes.php';
require_once 'app/helpers/autoload.php';

$cx = new Conexao();

var_dump($cx);

// $app = AppFactory::create();
// $app->setBasePath('/back'); // Define o caminho base do aplicativo


// $app->add(function (Request $request, $handler) { // Define o middleware para transformar a resposta em JSON
//     $response = $handler->handle($request);
//     return $response->withHeader('Content-Type', 'application/json');
// });

// require_once 'app/Components/Elemento.php';
// require_once 'app/Components/CompostoElemento.php';
// require_once 'app/Components/Composto_qui.php';
// require_once 'app/Components/MateriaPrima.php';

// require_once 'app/helpers/rota_nao_encontrada.php';
// $app->run();

