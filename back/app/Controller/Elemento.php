<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Model\Elemento as Model_Elemento;
use App\View\Elemento as View_Elemento;

class Elemento{

    private function m_Elemento() {
        return new Model_Elemento();
    }

    private function v_Elemento() {
        return new View_Elemento();
    }

    public function listarTodos(Request $req, Response $res, $args) {   
        $objElemento = $this->m_Elemento();
        $elementos = $objElemento->consultarTodos();        
        return $this->v_Elemento()->res_get($res ,$elementos,$objElemento->getErro());
    }
    public function listarPorId(Request $req, Response $res, $args) {   
        $id = $args['id'];
        $objElemento = $this->m_Elemento();
        $elemento = $objElemento->consultarPorId($id);
        return $this->v_Elemento()->res_get($res ,$elemento,$objElemento->getErro());
    }
    public function listarPor(Request $req, Response $res, $args) {   
        $objElemento = $this->m_Elemento();
        $tipo = $args['por'];
        if($tipo == 'simb'){
            $simb = $req->getQueryParams()['q'];
            $result = $objElemento->consultarSimbolo($simb);
        }
        elseif($tipo == 'nome'){
            $nome = $req->getQueryParams()['q'];
            $result = $objElemento->consultarTodos($nome);
        } 
        return $this->v_Elemento()->res_get($res ,$result, $objElemento->getErro());
    }
}