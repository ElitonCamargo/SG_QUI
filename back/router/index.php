<?php
$method =           $_SERVER['REQUEST_METHOD'];
$query_url =        $_SERVER['REQUEST_URI'];
$dadosRecebidos =   json_decode(file_get_contents('php://input'),false);
$rota =             @explode('/', @$_GET['url']);


require_once('routes.php');
if(end($rota)==''){ #Obtendo o último elemento do array 
    array_pop($rota); #Removendo o último elemento do array
}
if(array_key_exists($rota[0],$routers)){
    $req = [
        'parametro' =>$rota,
        'query_url' =>obterParametrosDaURL($query_url),
        'dados'     =>$dadosRecebidos
    ];
    if(isset($_SESSION['user_logado'])){        
        require_once($routers[$rota[0]]);
    }
    else{
        require_once($routers['usuario']);
    }
}
else{
    $codigo_resposta = 404;
    $result =[
        "erro"=>true,
        "inf"=>"Recurso não encontrado"
    ];
    require_once('components/error/Error.V.php');
}


function obterParametrosDaURL($url) {
    // Extrai a parte da URL após o ponto de interrogação
    $query = parse_url($url, PHP_URL_QUERY);
    // Inicializa um array para armazenar os parâmetros
    $parametros = [];

    // Se houver uma parte de consulta na URL
    if ($query) {
        // Analisa a string de consulta e armazena os parâmetros no array $parametros
        parse_str($query, $parametros);
    }
    return $parametros;
}
