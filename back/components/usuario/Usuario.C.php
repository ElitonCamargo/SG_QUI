<?php
require_once 'Usuario.M.php';
require_once 'Usuario.V.php';

switch($method){
    case "GET":{        
        GET($req);
    }break;
    case "POST":{
        POST($req);
    }break;
    case "DELETE":{

    }break;
    case "PUT":{

    }break;
    case "PATCH":{

    }break;
    default:{     
        $code_status = 500;
        $result = [
            "sucesso" => false,
            "erro" => "Método não suportado",
            "dados" => ""
        ];
        (new View())->res($code_status,$result);
    }break;
}



function GET($req) {
    $objUsuario = new Usuario();
    $id = @$req['parametro'][1];
    $query_url  = $req['query_url'];
    $result = [
        'sucesso' => false,
        'erro' => '',
        'dados' => ''
    ];
    if($req['parametro'][0]=="usuario"){
        if($id){
            $user = $objUsuario->consultarPorId($id);
            if($user){
                $result['sucesso'] = true;
                $result['dados'] = $user;
                $code_status = 202;
            }
            else{
                $erro = $objUsuario->getErro();
                $code_status = $erro != ""? 500:404;
                $erro = $erro != ""? $erro: "Usuário não encontrado";
                $result["erro"] = $erro;            
            }       
        }
        else{
            if(count($query_url)){
                if(isset($query_url['login']) && isset($query_url['senha'])){
                    if($objUsuario->login($query_url['login'],$query_url['senha'])){                        
                        $_SESSION['user_logado'] = serialize($objUsuario);
                        $code_status = 202;
                        $result['sucesso'] = true;
                        $result['info'] = "PHPSESSID: {$_COOKIE['PHPSESSID']}";
                        $result['dados'] = $objUsuario;                        
                    }
                    else{
                        $erro = $objUsuario->getErro();
                        $code_status = $erro != ""? 500:200;
                        $erro = $erro != ""? $erro: "Usuário ou senha inválido";
                        $result["erro"] = $erro; 
                    }
                }
                elseif(isset($query_url['logoff'])){                
                    $code_status = 200;
                    $result['sucesso'] = true;
                    unset($_SESSION['user_logado']);
                }
                else{                
                    $code_status = 404;
                    $result["erro"] = "Parâmetros de busca não localizado"; 
                }
            }
            else{
                $listaDeUsuarios = $objUsuario->consultarTodos();
                if($listaDeUsuarios){
                    $result['sucesso'] = true;
                    $result['dados'] = $listaDeUsuarios;
                    $code_status = 202;
                }else{
                    $erro = $objUsuario->getErro();
                    $code_status = $erro != ""? 500:404;
                    $erro = $erro != ""? $erro: "Usuário não encontrado";
                    $result["erro"] = $erro; 
                }
            }   
        }
    }
    else{        
        $code_status = 403;
        $result["erro"] =  "Acesso negado!";
    }
    (new View())->res($code_status,$result);
}


function POST($req) {
    $objUsuario = new Usuario();
    $dados  = $req['dados'];
    $result = [
        'sucesso' => false,
        'erro' => '',
        'dados' => ''
    ];
    $objUsuario->nome = $dados->nome;
    $objUsuario->email = $dados->email;
    $objUsuario->senha = $dados->senha;
    $objUsuario->permissao = $dados->permissao;
    $objUsuario->avatar = $dados->avatar;
    $objUsuario->status = $dados->status;

    $userCadastrado = $objUsuario->cadastrar();
    if($userCadastrado){
        $result['sucesso'] = true;
        $result['dados'] = $userCadastrado;
        $code_status = 202;
    }
    else{
        $erro = $objUsuario->getErro();
        $erro = $erro != ""? $erro: "Erro ao cadastrar usuáio";
        $code_status = 500;
        $result["erro"] = $erro;
    }     
    (new View())->res($code_status,$result);
    
}