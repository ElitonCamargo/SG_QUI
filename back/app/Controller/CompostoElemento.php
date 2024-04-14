<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Model\CompostoElemento as Model_CompostoElemento;
use App\View\CompostoElemento as View_CompostoElemento;

class CompostoElemento {
    private function m_CompostoElemento() {
        return new Model_CompostoElemento();
    }

    private function v_CompostoElemento() {
        return new View_CompostoElemento();
    }

    public function listar(Request $req, Response $res, $args) {
        $objCompostoElemento = $this->m_CompostoElemento();
        $search = $req->getQueryParams();
        // /composto_elemento?elementos=[1,2,3,4]
        if(isset($search['elementos'])){
            $elementos = explode(',',$search['elementos']);
            $dado = $objCompostoElemento->consultarCompostosPorElementos($elementos);
        }
        else{
            $objCompostoElemento->setErro("string query {".array_keys($search)[0]."} inválida");
            $dado = false;
        }
        return $this->v_CompostoElemento()->res_get($res, $dado, $objCompostoElemento->getErro());
    }

    public function listarPorElemento(Request $req, Response $res, $args) {
        // Implemente a lógica para listar compostos que possuem um elemento
    }

    public function cadastrar(Request $req, Response $res, $args) {
        // Implemente a lógica para cadastrar um composto que possui um elemento
    }

    public function delete(Request $req, Response $res, $args) {
        // Implemente a lógica para deletar um registro de composto que possui um elemento
    }

    public function alterar(Request $req, Response $res, $args) {
        // Implemente a lógica para alterar os dados de um registro de composto que possui um elemento
    }
}
