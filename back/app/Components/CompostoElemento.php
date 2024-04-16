<?php
namespace Compenents;

use app\database\Conexao;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;

// Model *********************************************************************************************************************************************
    class CompostoElemento {
        public $composto;
        public $elemento;
        public $quant;
        public $createdAt;
        public $updatedAt;
        private $erro;

        public function getErro(){
            return $this->erro;
        }

        public function setErro($erro){
            $this->erro = $erro;
        }

        private function cx(){
            return (new Conexao())->getConexao();
        }


        public function cadastrarTodos($composto,array $elemento): array|bool {
            $cx = $this->cx();
            $cmdSql = 'INSERT INTO composto_elemento(composto, elemento, quant) VALUES ';        
            foreach ($elemento as $key => $value) {
                $cmdSql .= "('$composto', getIdElementoBySimb('$key'), '$value'),";
            }
            $cmd = substr($cmdSql, 0, -1);
            $cmd .= ';';
            $stmt = $cx->prepare($cmd);
            try {
                $stmt->execute();
                if($stmt->rowCount()>0){
                    return $this->consultarElementosDoComposto($composto);
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao inserir: '. $e->getMessage();
                return false;
            }
        }
        public function cadastrar($composto,$elemento,$quant): CompostoElemento|bool {
            $cx = $this->cx();
            $cmdSql = 'INSERT INTO composto_elemento(composto, elemento, quant) VALUES (:composto,:elemento,:quant);'; 
            $stmt = $cx->prepare($cmdSql);
            $stmt->bindParam('composto',$composto);
            $stmt->bindParam('elemento',$elemento);
            $stmt->bindParam('quant',$quant);
            try {
                $stmt->execute();
                if($stmt->rowCount()>0){
                    return $this->consultar($composto,$elemento);
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao inserir: '. $e->getMessage();
                return false;
            }
        }

        public function consultar($composto,$elemento): CompostoElemento|bool{
            $cx = $this->cx();
            $cmdSql = "SELECT * FROM composto_elemento WHERE composto = :composto AND elemento = :elemento";
            $stmt = $cx->prepare($cmdSql);
            $stmt->bindParam('composto',$composto);
            $stmt->bindParam('elemento',$elemento);
            try {
                $stmt->execute();
                if($stmt->rowCount()>0){
                    $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
                    return $stmt->fetch(); 
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao consultar: '. $e->getMessage();
                return false;
            }
        }

        public function consultarElementosDoComposto($composto): array|bool {
            $cx = $this->cx();
            $stmt = $cx->prepare("SELECT composto_elemento.quant, elemento.* FROM elemento, composto_elemento WHERE elemento.id = composto_elemento.elemento AND composto_elemento.composto = :composto");
            try {
                $stmt->bindParam(':composto', $composto);          
                if($stmt->execute()){
                    return $stmt->fetchAll(PDO::FETCH_CLASS, 'stdClass'); 
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar elementos: '. $e->getMessage();
                return false;
            }
        }

        public function consultarCompostosPorElementos(array $id_elementos, $op_logico='or'): array|bool {
            $cx = $this->cx(); 
            $cmdSql = "";
            if($op_logico == 'or'){
                $cmdSql .= 'SELECT composto_qui.*, COUNT(composto_qui.id) as compatibilidade FROM  composto_elemento INNER JOIN  composto_qui ON composto_elemento.composto = composto_qui.id WHERE  composto_elemento.elemento IN(';
                foreach ($id_elementos as $value) {
                    $cmdSql .= $value.',';
                }
                $cmdSql= substr($cmdSql, 0, -1);
                $cmdSql .= ')GROUP BY (composto_qui.id) ORDER BY compatibilidade DESC;';
            }else{

                $cmdSql = "SELECT composto_qui.* FROM composto_qui,";
                $from = '';
                $join = ' WHERE ';
                $where = '';
                foreach ($id_elementos as $value) {
                    $from .= " composto_elemento as ce$value,";
                    $join .= " composto_qui.id = ce$value.composto AND";
                    $where .= " ce$value.elemento = $value AND";
                }
                $from = substr($from, 0, -1);
                $where = substr($where, 0, -4);
                $cmdSql.= $from.$join.$where.';';
            }

            $stmt = $cx->prepare($cmdSql);
            try {         
                if($stmt->execute()){
                    return $stmt->fetchAll(PDO::FETCH_CLASS, 'stdClass'); 
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar compostos: '. $e->getMessage();
                return false;
            }
        }

        public function deletar($composto, $elemento): bool {
            $cx = $this->cx();
            $stmt = $cx->prepare("DELETE FROM composto_elemento WHERE composto = :composto AND elemento = :elemento");
            try {
                $stmt->bindParam(':composto', $composto);
                $stmt->bindParam(':elemento', $elemento);
                $stmt->execute();
                return $stmt->rowCount() > 0;

            } catch (\PDOException $e) {
                $this->erro = 'Erro ao deletar elemento: '. $e->getMessage();
                return false;
            }
        }
        public function alterar($composto,$elemento,$quant): CompostoElemento|bool{
            $cx = $this->cx();
            $cmdSql = 'UPDATE composto_elemento SET quant=:quant WHERE composto=:composto and elemento=:elemento'; 
            
            $stmt = $cx->prepare($cmdSql);
            $stmt->bindParam('composto',$composto);
            $stmt->bindParam('elemento',$elemento);
            $stmt->bindParam('quant',$quant);
            try {
                $stmt->execute();
                if($stmt->rowCount()>0){
                    return $this->consultar($composto,$elemento);
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao inserir: '. $e->getMessage();
                return false;
            }
        }
    }



// View ****************************************************************************************************************************************
    function CompostoElemento_res_get(Response $res, $dados, $erro) {
        $status = 0;
        $success = [
            "data" => $dados,
            "code" => 200
        ];
        $error = [
            "message" => $erro ? $erro : "Recurso não encontrado",
            "code" => 404
        ];
        $result = [];
        if ($dados) {
            $result['success'] = $success;
            $status = 200;
        } else {
            $result['error'] = $error;
            $status = 404;
        }
        $res->getBody()->write(json_encode($result));
        return $res->withStatus($status);
    }

    function CompostoElemento_res_post(Response $res, $dados, $erro) {
        $status = 0;
        $success = [
            "data" => $dados,
            "code" => 202
        ];
        $error = [
            "message" => $erro ? $erro : "Não foi possível cadastar:",
            "code" => $erro?500:404
        ];
        $result = [];
        if ($dados) {
            $result['success'] = $success;
            $status = 202;
        } else {
            $result['error'] = $error;
            $status = $error['code'];
        }
        $res->getBody()->write(json_encode($result));
        return $res->withStatus($status);
    }

    function CompostoElemento_res_put(Response $res, $dados, $erro) {
        $status = 0;
        $success = [
            "data" => $dados,
            "code" => 200
        ];
        $error = [
            "message" => $erro ? $erro : "Não foi possível alterar:",
            "code" => $erro?500:404
        ];
        $result = [];
        if ($dados) {
            $result['success'] = $success;
            $status = 200;
        } else {
            $result['error'] = $error;
            $status = $error['code'];
        }
        $res->getBody()->write(json_encode($result));
        return $res->withStatus($status);
    }

    function CompostoElemento_res_delete(Response $res, $return, $erro) {
        
        $status = 0;
        $success = [
            "data" => ["Dados"=>"Excluiido"],
            "code" => 204
        ];
        $error = [
            "message" => $erro ? $erro : "Recurso não encontrado",
            "code" => $erro ? 500:404
        ];
        $result = [];
     
        if ($return) {
            $result['success'] = $success;
            $status = 204;
        } else {
            $result['error'] = $error;
            $status = $error['code'];
        }
        $res->getBody()->write(json_encode($result));
        return $res->withStatus($status);
    }

// Controller ****************************************************************************************************************************************
   
    $compostoElemento = new CompostoElemento();
    // GET
        $app->get('/composto_elemento', function(Request $req, Response $res, $args) use ($compostoElemento){
            $search = $req->getQueryParams();
            // /composto_elemento?elementos=[1,2,3,4]
            if(isset($search['elementos'])){
                $op = $search['op'];
                $elementos = explode(',',$search['elementos']);
                $dado = $compostoElemento->consultarCompostosPorElementos($elementos,$op);
            }
            elseif(isset($search['composto'])){
                $elementos = $search['composto'];
                $dado = $compostoElemento->consultarElementosDoComposto($elementos);
            }
            else{
                $compostoElemento->setErro("string query {".array_keys($search)[0]."} inválida");
                $dado = false;
            }
            return CompostoElemento_res_get($res, $dado, $compostoElemento->getErro());
        }); 
        $app->get('/composto_elemento/{composto}/{elemento}', function(Request $req, Response $res, $args) use ($compostoElemento){
            $composto = $args['composto'];
            $elemento = $args['elemento'];
            $dado = $compostoElemento->consultar($composto,$elemento);
            return CompostoElemento_res_get($res, $dado, $compostoElemento->getErro());
        }); 
        
    //DELETE
        $app->DELETE('/composto_elemento/{composto}/{elemento}', function(Request $req, Response $res, $args) use ($compostoElemento){
            $composto = $args['composto'];
            $elemento = $args['elemento'];
            $dado = $compostoElemento->deletar($composto,$elemento);
            return CompostoElemento_res_delete($res, $dado, $compostoElemento->getErro());
        }); 
    // POST
        $app->POST('/composto_elemento', function(Request $req, Response $res, $args) use ($compostoElemento){            
            $body = $req->getBody();
            $dados = json_decode($body,true);
            $composto = $dados['composto'];
            $elemento = $dados['elemento'];
            $quant = $dados['quant'];
            $dado = $compostoElemento->cadastrar($composto,$elemento,$quant);
            return CompostoElemento_res_post($res, $dado, $compostoElemento->getErro());
        }); 
    // 
        $app->PATCH('/composto_elemento/{composto}/{elemento}', function(Request $req, Response $res, $args) use ($compostoElemento){
            $composto = $args['composto'];
            $elemento = $args['elemento'];
            $body = $req->getBody();
            $dados = json_decode($body,true);
            $quant = $dados['quant'];
            $dado = $compostoElemento->alterar($composto,$elemento,$quant);
            return CompostoElemento_res_put($res, $dado, $compostoElemento->getErro());
        }); 
        

    