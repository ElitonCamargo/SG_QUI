<?php
namespace app\database;
use PDO;

class Conexao{
    private $servidor;
    private $baseDeDados;
    private $usuario;
    private $senha;

    public function __construct(){
        $this->servidor = '108.167.151.37';
        $this->baseDeDados = 'drawbe66_sgqui';
        $this->usuario = 'drawbe66_sgqui';
        $this->senha = 'Sg_Qui123';
    }
    public function getConexao(){
        return new PDO("mysql:host=$this->servidor;dbname=$this->baseDeDados", $this->usuario, $this->senha);
    }

}

    // public function __construct(){
    //     $this->servidor = 'localhost';
    //     $this->baseDeDados = 'sg_qui';
    //     $this->usuario = 'root';
    //     $this->senha = '';
    // }