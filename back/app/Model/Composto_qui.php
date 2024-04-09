<?php
namespace App\Model;

use App\database\Conexao;
use PDO;

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
        $stmt = $cx->prepare("SELECT * FROM composto_qui WHERE compost_qui.nome like :filtro");
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

    public function consultarPorNome($nome): Composto_qui|bool
    {
        $cx = $this->cx();
        $stmt = $cx->prepare("SELECT * FROM composto_qui WHERE compost_qui.nome = :nome");
        try {
            $stmt->bindParam('nome', $nome);          
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

    public function consultarPorFormula($formula): Composto_qui|bool
    {
        $cx = $this->cx();
        $stmt = $cx->prepare("SELECT * FROM composto_qui WHERE compost_qui.formula = :formula");
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
        $stmt = $cx->prepare("SELECT * FROM composto_qui WHERE compost_qui.id = :id");
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
        $stmt = $cx->prepare("SELECT * FROM composto_qui WHERE compost_qui.cas_number = :cas_number");
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

    public function deletar():bool
    {
        $cx = $this->cx();
        $stmt = $cx->prepare("DELETE FROM composto_qui WHERE compost_qui.id = :id");
        try {
            $stmt->bindParam('id', $this->id);
            return $stmt->execute();
        } catch (\PDOException $e) {
            $this->erro = 'Erro ao deletar composto: '. $e->getMessage();
            return false;
        }
    }

    public function alterar():Composto_qui|bool
    {
        $cx = $this->cx();
        $stmt = $cx->prepare("UPDATE composto_qui SET nome = :nome, formula = :formula, cas_number = :cas_number, densidade = :densidade, fusao = :fusao, ebulicao = :ebulicao, massa_molar = :massa_molar, estrutura_molecular = :estrutura_molecular, classificacao = :classificacao, descricao = :descricao WHERE compost_qui.id = :id");
        $dados = [
            'id'=>$this->id,
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
            return $stmt->execute($dados);
        } catch (\PDOException $e) {
            $this->erro = 'Erro ao alterar composto: '. $e->getMessage();
            return false;
        }
    }

}