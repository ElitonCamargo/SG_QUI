<?php
namespace Compenents;

use app\database\Conexao;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Compenents\CompostoElemento;
use PDO;

// Model *********************************************************************************************************************************************
    class Composto_qui{
        public $id;
        public $nome;
        public $formula;
        public $cas_number;
        public $densidade;
        public $fusao;
        public $ebulicao;
        public $massa_molar;
        public $estrutura_molecular;
        public $classificacao;
        public $descricao;
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

        public function cadastrar():Composto_qui|bool{
            $cx = $this->cx();
            $stmt = $cx->prepare("INSERT INTO composto_qui (nome,formula,cas_number,densidade,fusao,ebulicao,massa_molar,estrutura_molecular,classificacao,descricao) VALUES (:nome,:formula,:cas_number,:densidade,:fusao,:ebulicao,:massa_molar,:estrutura_molecular,:classificacao,:descricao)");
            $dados = [
                'nome'=>$this->nome,
                'formula'=>$this->formula,
                'cas_number'=>$this->cas_number,
                'densidade'=>$this->densidade,
                'fusao'=>$this->fusao,
                'ebulicao'=>$this->ebulicao,
                'massa_molar'=>$this->massa_molar,
                'estrutura_molecular'=>$this->estrutura_molecular,
                'classificacao'=>$this->classificacao,
                'descricao'=>$this->descricao
            ];
            try {
                $stmt->execute($dados);
                return $this->consultarPorId($cx->lastInsertId());
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao inserir composto: '. $e->getMessage();
                return false;
            }
        }

        public function consultarTodos($filtro=""): array|bool
        {
            $cx = $this->cx();
            $stmt = $cx->prepare("SELECT * FROM composto_qui WHERE nome like :filtro");
            try {                    
                $stmt->bindValue(':filtro', '%'.$filtro.'%');
                $stmt->execute();
                if($stmt->rowCount()){
                    return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar composto: '. $e->getMessage();
                return false;
            }
        }


        public function consultarPorFormula($formula): Composto_qui|bool
        {
            $cx = $this->cx();
            $stmt = $cx->prepare("SELECT * FROM composto_qui WHERE formula = :formula");
            try {
                $stmt->bindParam('formula', $formula);          
                if($stmt->execute()){
                    $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
                    return $stmt->fetch(); 
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar composto: '. $e->getMessage();
                return false;
            }
        }

        public function consultarPorId($id): Composto_qui|bool
        {
            $cx = $this->cx();
            $stmt = $cx->prepare("SELECT * FROM composto_qui WHERE id = :id");
            try {
                $stmt->bindParam('id', $id);          
                if($stmt->execute()){
                    $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
                    return $stmt->fetch(); 
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar composto: '. $e->getMessage();
                return false;
            }
        }

        public function consultarPorCas_number($cas_number): Composto_qui|bool
        {
            $cx = $this->cx();
            $stmt = $cx->prepare("SELECT * FROM composto_qui WHERE cas_number = :cas_number");
            try {
                $stmt->bindParam('cas_number', $cas_number);          
                if($stmt->execute()){
                    $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
                    return $stmt->fetch(); 
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar composto: '. $e->getMessage();
                return false;
            }
        }

        public function deletar($id):bool
        {
            $cx = $this->cx();
            $stmt = $cx->prepare("DELETE FROM composto_qui WHERE id = :id");
            try {
                $stmt->bindParam('id', $id);
                $stmt->execute();
                if($stmt->rowCount()>0){
                    return true;
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao deletar composto: '. $e->getMessage();
                return false;
            }
        }

        public function alterar($id, array $dados):Composto_qui|bool
        {
            $cx = $this->cx();      
            $cmd = 'UPDATE composto_qui SET';
            $valores[':id'] = $id;
            foreach ($dados as $key => $value) {
                $cmd .= " $key = :$key,";
                $valores[":$key"] = $value;
            }
            $cmd = substr($cmd, 0, -1);
            $cmd .= " WHERE id = :id";
            $stmt = $cx->prepare($cmd);
            
            try {
                $stmt->execute($valores);
                if($stmt->rowCount()>0){
                    return $this->consultarPorId($id);
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao alterar composto: '. $e->getMessage();
                return false;
            }
        }
    }
// View **********************************************************************************************************************************************
    function Composto_qui_res_get(Response $res, $dados, $erro) {
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

    function Composto_qui_res_post(Response $res, $dados, $elementos, $erro) {
        $status = 0;
        $success = [
            "data" => [
                "composto_qui"=>$dados,
                "composicao"=>$elementos
            ],
            "code" => 202
        ];
        $error = [
            "message" => $erro ? $erro : "Não foi possível cadastar composto",
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

    function Composto_qui_res_put(Response $res, $dados, $erro) {
        $status = 0;
        $success = [
            "data" => $dados,
            "code" => 200
        ];
        $error = [
            "message" => $erro ? $erro : "Não foi possível alterar composto",
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

    function Composto_qui_res_delete(Response $res, $return, $erro) {
        $status = 0;
        $success = [
            "data" => [],
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
    // GET
        $composto_qui = new Composto_qui();
        $app->get('/composto_qui', function(Request $req, Response $res, $args) use ($composto_qui){
            $search = $req->getQueryParams();
            if(count($search) == 0){
                $compostos = $composto_qui->consultarTodos();
            }
            elseif(isset($search['nome'])){
                $compostos = $composto_qui->consultarTodos($search['nome']);
            }
            elseif(isset($search['formula'])){
                $compostos = $composto_qui->consultarPorFormula($search['formula']);
            }
            elseif(isset($search['cas_number'])){
                $compostos = $composto_qui->consultarPorCas_number($search['cas_number']);
            }
            else{
                $composto_qui->setErro("string query {".array_keys($search)[0]."} inválida");
                $compostos = false;
            }
            return Composto_qui_res_get($res, $compostos, $composto_qui->getErro());
        }); 

        $app->get('/composto_qui/{id}', function(Request $req, Response $res, $args) use ($composto_qui){
            $composto = $composto_qui->consultarPorId($args['id']);
            return Composto_qui_res_get($res, $composto, $composto_qui->getErro());
        }); 
    // POST
        $app->post('/composto_qui', function(Request $req, Response $res, $args) use ($composto_qui){
            $body = $req->getBody();
            $dados = json_decode($body,true);
            foreach ($dados as $chave => $valor) {
                $composto_qui->$chave = $valor;
            }
            $compostos = $composto_qui->cadastrar();
            $elementos = [];
            if($compostos){
                $id_composto = $compostos->id;
                $composicao_composto = analisarFormulaQuimica($dados['formula']);
                $compostoElemento = new CompostoElemento();
                $elementos = $compostoElemento->cadastrarTodos($id_composto,$composicao_composto);
            }
            return Composto_qui_res_post($res, $compostos, $elementos, $composto_qui->getErro());
        });
    // DELETE
        $app->delete('/composto_qui/{id}', function(Request $req, Response $res, $args) use ($composto_qui){
            $result = $composto_qui->deletar($args['id']);        
            return Composto_qui_res_delete($res, $result, $composto_qui->getErro());
        });
    // Alterar   
        $app->patch('/composto_qui/{id}', function(Request $req, Response $res, $args) use ($composto_qui){
            $body = $req->getBody();        
            $dados = json_decode($body,true);     
            $compostos = $composto_qui->alterar($args['id'],$dados);
            return Composto_qui_res_put($res, $compostos, $composto_qui->getErro());
        });

