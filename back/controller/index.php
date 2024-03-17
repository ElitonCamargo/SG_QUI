<?php
# Os dados de requisição enviados para a API estão sendo salvos dentro da variáveis [$method, $dadosRecebidos, $url]
$method = $_SERVER['REQUEST_METHOD'];
$dadosRecebidos = json_decode(file_get_contents('php://input'));
$url = explode('/', @$_GET['url']);

# Definindo todos as contas possíveis da aplicação;
require_once 'router.php';
# Direcionando a aplicação para a rota especifica.
$rota = $url[0];
if(array_key_exists($rota,$rotas)){
    require_once $rotas[$rota];
}
else{    
    $codigo_resposta = 404;
    $erro = [
        'result'=>false,
        'erro'  => 'Erro: 404 - Recurso não encontrado'
    ];
    require_once 'view/erro404.php';
}

