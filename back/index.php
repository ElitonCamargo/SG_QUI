<?php
header('Content-type: application/json');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// ***** Caso seja necessário liberar acesso vindo de fora do servidor ****************
// $origin = @$_SERVER['HTTP_ORIGIN']; //Liberar todas as origens
// header("Access-Control-Allow-Origin: $origin");
// header("Access-Control-Allow-Headers: Content-Type");
//*************************************************************************************
$server = json_encode($_SERVER);
echo $server;
