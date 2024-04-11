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

    // public function consultarCompostoPorElemento(Request $req, Response $res, $args) {
    //     $objCompostoElemento = $this->m_CompostoElemento();
    //     $search = $req->getQueryParams();

    //     if(isset($search['nome'])){
    //         $compostos = $objCompostoElemento->consultarCompostoPorElemento();
    //     }
    //     elseif(isset($search['formula'])){
    //         $compostos = $objCompostoElemento->consultarPorFormula($search['formula']);
    //     }
    //     elseif(isset($search['cas_number'])){
    //         $compostos = $objCompostoElemento->consultarPorCas_number($search['cas_number']);
    //     }
    //     else{
    //         $objCompostoElemento->setErro("string query {".array_keys($search)[0]."} inválida");
    //         $compostos = false;
    //     }
    //     return $this->v_Composto_qui()->res_get($res, $compostos, $objCompostoElemento->getErro());
    // }

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
