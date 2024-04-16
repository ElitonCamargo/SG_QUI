<?php
namespace App\Model;

use app\database\Conexao;
use PDO;

class Usuario{
    public $id;
    public $nome;
    public $email;
    public $senha;
    public $permissao;
    public $avatar;
    public $status;
    public $createdAt;
    public $updatedAt;
    private $erro;

    public function getErro(){
        return $this->erro;
    }

    private function criptografarSenha($senha):string{
        return password_hash($senha,PASSWORD_BCRYPT,['cost' => 12]);
    }
  
    private function compararCriptografia($senha, $criptografia):bool{
        return password_verify($senha, $criptografia);
    }

    private function cx(){
        return (new Conexao())->getConexao();
    }
     

    public function cadastrar():Usuario|bool{
        $cx = $this->cx();
        $stmt = $cx->prepare("INSERT INTO Usuario (nome,email,senha,permissao,avatar,status) VALUES (:nome,:email,:senha,:permissao,:avatar,:status)");
        $dados = [
            'nome'=>$this->nome,
            'email'=>$this->email,
            'senha'=>$this->criptografarSenha($this->senha),
            'permissao'=>$this->permissao,
            'avatar'=>$this->avatar,
            'status'=>$this->status
        ];
        try {
            $stmt->execute($dados);
            return $this->consultarPorId($cx->lastInsertId());
        } catch (\PDOException $e) {
            $this->erro = 'Erro ao inserir usuário: ' . $e->getMessage();
            return false;
        }
    }
  

    public function consultarPorId($id): Usuario|bool
    {
        $cx = $this->cx();
        $stmt = $cx->prepare("SELECT * FROM Usuario WHERE Usuario.id = :id");
        try {
            $stmt->bindParam('id', $id);          
            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
                return $stmt->fetch(); 
            }
            return false;
        } catch (\PDOException $e) {
            $this->erro = 'Erro ao selecionar usuário: ' . $e->getMessage();
            return false;
        }
    }

    public function consultarPorEmail($email): Usuario|bool
    {
        $cx = $this->cx();
        $stmt = $cx->prepare("SELECT * FROM Usuario WHERE Usuario.email = :email");
        try {
            $stmt->bindParam('email', $email);          
            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
                return $stmt->fetch(); 
            }
            return false;
        } catch (\PDOException $e) {
            $this->erro = 'Erro ao selecionar usuário: ' . $e->getMessage();
            return false;
        }
    }
    public function consultarTodos($filtro=""): array|bool
    {
        $cx = $this->cx();
        $stmt = $cx->prepare("SELECT * FROM Usuario WHERE Usuario.nome like :filtro");
        try {                    
            $stmt->bindValue(':filtro', '%'.$filtro.'%');
            $stmt->execute();
            if($stmt->rowCount()){
                return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
            }
            return false;
        } catch (\PDOException $e) {
            $this->erro = 'Erro ao selecionar usuário: ' . $e->getMessage();
            return false;
        }
    }

    public function login($email, $senha): bool{
        $usuario = $this->consultarPorEmail($email);
        if($usuario){
            $this->id = $usuario->id;
            $this->nome = $usuario->nome;
            $this->email = $usuario->email;
            $this->senha = $usuario->senha;
            $this->permissao = $usuario->permissao;
            $this->avatar = $usuario->avatar;
            $this->status = $usuario->status;
            $this->createdAt = $usuario->createdAt;
            $this->updatedAt = $usuario->updatedAt;
            return $this->compararCriptografia($senha,$this->senha);
        }
        return false;
    } 


}