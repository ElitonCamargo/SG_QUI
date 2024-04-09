<?php
namespace App\View;
use Psr\Http\Message\ResponseInterface as Response;

class Elemento{
    public function res_get(Response $res, $dados,$erro){
        $status=0;
        $sucess = [
            "dados"     =>  $dados,
            "code"  =>  200
        ];
        $error = [
            "message"=>$erro?$erro:"recurso não encontrado",
            "code"=> 404
        ];
        $result = [];
        if($dados){
            $result['sucess']  =$sucess;
            $status = 200;
        }
        else{
            $result['error'] = $error;
            $status = 404;
        }
        $res->getBody()->write(json_encode($result));
        return $res->withStatus($status);
    }    
}