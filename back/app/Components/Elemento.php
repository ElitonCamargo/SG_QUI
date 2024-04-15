<?php
namespace Compenents;

use App\database\Conexao;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;
//Model ****************************************************************************************************************************************
    class Elemento{
        public $id;
        public $simbolo;
        public $nome;
        public $numero_atomico;
        public $massa_atomica;
        public $grupo;
        public $periodo;
        public $ponto_de_fusao;
        public $ponto_de_ebulicao;
        public $densidade;
        public $estado_padrao;
        public $configuracao_eletronica;
        public $propriedades;
        private $erro;

        public function getErro(){
            return $this->erro;
        }

        private function cx(){
            return (new Conexao())->getConexao();
        }


        public function consultarPorId($id): Elemento|bool
        {
            $cx = $this->cx();
            $stmt = $cx->prepare("SELECT * FROM elemento WHERE id = :id");
            try {
                $stmt->bindParam('id', $id);          
                if($stmt->execute()){
                    $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
                    return $stmt->fetch(); 
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar elemento: ' . $e->getMessage();
                return false;
            }
        }

        public function consultarSimbolo($simbolo): Elemento|bool
        {
            $cx = $this->cx();
            $stmt = $cx->prepare("SELECT * FROM elemento WHERE simbolo like :simbolo");
            try {                    
                $stmt->bindParam('simbolo', $simbolo);
                $stmt->execute();
                if($stmt->rowCount()){
                    $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
                    return $stmt->fetch(); 
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar elementos: ' . $e->getMessage();
                return false;
            }
        }

        public function consultarTodos($filtro=""): array|bool
        {
            $cx = $this->cx();
            $stmt = $cx->prepare("SELECT * FROM elemento WHERE nome like :filtro");
            try {                    
                $stmt->bindValue(':filtro', '%'.$filtro.'%');
                $stmt->execute();
                if($stmt->rowCount()){
                    return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar elementos: ' . $e->getMessage();
                return false;
            }
        }


        public function consultarComFiltro($search=""): array|bool
        {
            $cx = $this->cx();
            $stmt = $cx->prepare("SELECT * FROM elemento WHERE nome LIKE :search OR simbolo LIKE :search OR numero_atomico LIKE :search OR grupo LIKE :search OR periodo LIKE :search OR ponto_de_fusao LIKE :search OR ponto_de_ebulicao LIKE :search OR densidade LIKE :search OR estado_padrao LIKE :search OR configuracao_eletronica LIKE :search OR propriedades LIKE :search");
            try {                    
                $stmt->bindValue(':search', '%'.$search.'%');
                $stmt->execute();
                if($stmt->rowCount()){
                    return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar elementos: ' . $e->getMessage();
                return false;
            }
        }
}

// View ****************************************************************************************************************************************
    function Elemento_res_get(Response $res, $dados,$erro){
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

// Controller ****************************************************************************************************************************************
    $elemento = new Elemento();
    $app->get('/elemento', function(Request $req, Response $res, $args)use ($elemento){
        $search = $req->getQueryParams();
        if(count($search) == 0){
            $elementos = $elemento->consultarTodos(); 
        }
        elseif(isset($search['nome'])){
            $elementos = $elemento->consultarTodos($search['nome']);
        }
        elseif(isset($search['simbolo'])){
            $elementos = $elemento->consultarSimbolo($search['simbolo']);
        }       
        return Elemento_res_get($res ,$elementos, $elemento->getErro());
    }
    ); 

    $app->get('/elemento/{id}', function(Request $req, Response $res, $args)use ($elemento){
        $id = $args['id'];
        $result = $elemento->consultarPorId($id);
        return Elemento_res_get($res ,$result, $elemento->getErro());
        }
    );