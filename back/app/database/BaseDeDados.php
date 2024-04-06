<?php
namespace App\database;
use PDO;

class Conexao{
    private $servidor;
    private $baseDeDados;
    private $usuario;
    private $senha;

    public function __construct(){
        $this->servidor = 'localhost';
        $this->baseDeDados = 'sg_qui';
        $this->usuario = 'root';
        $this->senha = '';
    }
    public function getConexao(){
        return new PDO("mysql:host=$this->servidor;dbname=$this->baseDeDados", $this->usuario, $this->senha);
    }
}