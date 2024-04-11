<?php
namespace App\Model;
use App\Model\Elemento;
use App\database\Conexao;
use PDO;

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

    public function consultarElementosDoComposto($composto): array|bool {
        $cx = $this->cx();
        $stmt = $cx->prepare("SELECT elemento.* FROM elemento, composto_elemento WHERE elemento.id = composto_elemento.elemento AND composto_elemento.composto = :composto");
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

    public function consultarCompostoPorElemento(array $id_elementos): array|bool {
        $cx = $this->cx();
        $cmdSql = "SELECT composto_qui.* FROM composto_qui INNER JOIN composto_elemento ON composto_elemento.composto = composto_qui.id WHERE composto_elemento.elemento IN (";

        foreach ($id_elementos as $value) {
            $cmdSql .= "$value,";
        }
        $cmd = substr($cmdSql, 0, -1);
        $cmd .= ');';
        $stmt = $cx->prepare($cmd);
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

    // public function alterar(): CompostoElemento|bool {
    //     // Implemente a lógica para alterar os dados de um registro de composto que possui um elemento
    // }
}
