<?php
    require_once 'BaseDeDados.php';
    class Cliente{
        public $id;
        public $cnpj_cpf;
        public $nome;
        public $endereco;
        public $email;
        public $telefone;
        public $data_cadastro;
        public $tipo_cliente;
        public $status_cliente;
        public $observacoes;
        public $createdAt;
        public $updatedAt;
        public $erro;
        
        public function getErro(){
            return $this->erro;
        }
    
        private function cx(){
            return (new BaseDeDados())->getConexao();
        }

        public function cadastrar():bool {
            try {
    
                $cmdSql = 'INSERT INTO Clientes (cnpj_cpf, nome, endereco, email, telefone, tipo_cliente, status_cliente, observacoes) VALUES';
                $cmdSql += '(:cnpj_cpf, :nome, :endereco, :email, :telefone, :data_cadastro, :tipo_cliente, :status_cliente, :observacoes)';
                $cx_declarada = $this->cx()->prepare($cmdSql);
                $cx_declarada->bindParam('cnpj_cpf', $this->cnpj_cpf);          
                $cx_declarada->bindParam('nome', $this->nome);          
                $cx_declarada->bindParam('endereco', $this->endereco);          
                $cx_declarada->bindParam('email', $this->email);          
                $cx_declarada->bindParam('telefone', $this->telefone);                    
                $cx_declarada->bindParam('tipo_cliente', $this->tipo_cliente);          
                $cx_declarada->bindParam('status_cliente', $this->status_cliente);          
                $cx_declarada->bindParam('observacoes', $this->observacoes);          
                return $cx_declarada->execute();
            } catch (\PDOException $e) {
                $this->erro = "Erro ao cadastrar categoria: " . $e->getMessage();
                return false;
            }
        }
    }