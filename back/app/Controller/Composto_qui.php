<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Model\Composto_qui as Model_Composto_qui;
use App\View\Composto_qui as View_Composto_qui;
use App\Model\CompostoElemento as M_CompostoElemento;

class Composto_qui {
    private function m_Composto_qui() {
        return new Model_Composto_qui();
    }

    private function v_Composto_qui() {
        return new View_Composto_qui();
    }
// * Leitura *************************************************************
    public function listarTodos(Request $req, Response $res, $args) {
        $objComposto_qui = $this->m_Composto_qui();
        $search = $req->getQueryParams();
        if(count($search) == 0){
            $compostos = $objComposto_qui->consultarTodos();
        }
        elseif(isset($search['nome'])){
            $compostos = $objComposto_qui->consultarTodos($search['nome']);
        }
        elseif(isset($search['formula'])){
            $compostos = $objComposto_qui->consultarPorFormula($search['formula']);
        }
        elseif(isset($search['cas_number'])){
            $compostos = $objComposto_qui->consultarPorCas_number($search['cas_number']);
        }
        else{
            $objComposto_qui->setErro("string query {".array_keys($search)[0]."} inválida");
            $compostos = false;
        }
        return $this->v_Composto_qui()->res_get($res, $compostos, $objComposto_qui->getErro());
    }

    public function listarPorId(Request $req, Response $res, $args) {
        $id = $args['id'];
        $objComposto_qui = $this->m_Composto_qui();
        $composto = $objComposto_qui->consultarPorId($id);
        return $this->v_Composto_qui()->res_get($res, $composto, $objComposto_qui->getErro());
    }

//* Criação ************************************************************** 
    
    public function cadastrar(Request $req, Response $res, $args) {
        $body = $req->getBody();
        $dados = json_decode($body,true);
        $objComposto_qui = $this->m_Composto_qui();
        $objComposto_qui->nome                = $dados['nome'];
        $objComposto_qui->formula             = $dados['formula'];    
        $objComposto_qui->cas_number          = $dados['cas_number'];        
        $objComposto_qui->densidade           = $dados['densidade'];    
        $objComposto_qui->fusao               = $dados['fusao'];
        $objComposto_qui->ebulicao            = $dados['ebulicao'];    
        $objComposto_qui->massa_molar         = $dados['massa_molar'];        
        $objComposto_qui->estrutura_molecular = $dados['estrutura_molecular'];                
        $objComposto_qui->classificacao       = $dados['classificacao'];        
        $objComposto_qui->descricao           = $dados['descricao'];    
        $compostos = $objComposto_qui->cadastrar();
        $elementos = [];
        if($compostos){
            $id_composto = $compostos->id;
            $composicao_composto = analisarFormulaQuimica($dados['formula']);
            $compostoElemento = new M_CompostoElemento();
            $elementos = $compostoElemento->cadastrarTodos($id_composto,$composicao_composto);
        }
        return $this->v_Composto_qui()->res_post($res, $compostos, $elementos, $objComposto_qui->getErro());
    }
//* Deletar ***********************************************************
    public function delete(Request $req, Response $res, $args) {
        $id = $args['id'];
        $objComposto_qui = $this->m_Composto_qui();
        $result = $objComposto_qui->deletar($id);        
        return $this->v_Composto_qui()->res_delete($res, $result, $objComposto_qui->getErro());
    }
//* Altear ***********************************************************
    public function alterar(Request $req, Response $res, $args) {
        $body = $req->getBody();
        $dados = json_decode($body,true);
        $objComposto_qui = $this->m_Composto_qui();
        $objComposto_qui->id = $args['id'];
        $objComposto_qui->nome                = $dados['nome'];
        $objComposto_qui->formula             = $dados['formula'];    
        $objComposto_qui->cas_number          = $dados['cas_number'];        
        $objComposto_qui->densidade           = $dados['densidade'];    
        $objComposto_qui->fusao               = $dados['fusao'];
        $objComposto_qui->ebulicao            = $dados['ebulicao'];    
        $objComposto_qui->massa_molar         = $dados['massa_molar'];        
        $objComposto_qui->estrutura_molecular = $dados['estrutura_molecular'];                
        $objComposto_qui->classificacao       = $dados['classificacao'];        
        $objComposto_qui->descricao           = $dados['descricao'];    
        $compostos = $objComposto_qui->alterar();
        return $this->v_Composto_qui()->res_put($res, $compostos, $objComposto_qui->getErro());
    }

    public function alteracao_seletiva(Request $req, Response $res, $args) {
        $body = $req->getBody();        
        $dados = json_decode($body,true);
        $objComposto_qui = $this->m_Composto_qui();       
        $compostos = $objComposto_qui->alteracao_seletiva($args['id'],$dados);
        return $this->v_Composto_qui()->res_put($res, $compostos, $objComposto_qui->getErro());
    }
}
