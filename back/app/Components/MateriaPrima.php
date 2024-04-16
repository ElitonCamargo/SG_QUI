<?php
namespace Compenents;

use app\database\Conexao;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;
//Model ****************************************************************************************************************************************

    class MateriaPrima {
        public $id;
        public $nome;
        public $densidade;
        public $descricao;
        public $grupo;
        public $createdAt;
        public $updatedAt;
        private $erro;

        public function getErro() {
            return $this->erro;
        }

        public function setErro($erro) {
            $this->erro = $erro;
        }

        private function cx() {
            return (new Conexao())->getConexao();
        }

        public function cadastrar(): MateriaPrima|bool {
            $cx = $this->cx();
            $stmt = $cx->prepare("INSERT INTO materia_prima (nome, densidade, descricao, grupo) VALUES (:nome, :densidade, :descricao, :grupo)");
            $dados = [
                'nome' => $this->nome,
                'densidade' => $this->densidade,
                'descricao' => $this->descricao,
                'grupo' => $this->grupo
            ];
            try {
                $stmt->execute($dados);
                return $this->consultarPorId($cx->lastInsertId());
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao inserir matéria-prima: ' . $e->getMessage();
                return false;
            }
        }

        public function consultarTodos($filtro = ""): array|bool {
            $cx = $this->cx();
            $stmt = $cx->prepare("SELECT * FROM materia_prima WHERE nome LIKE :filtro");
            try {
                $stmt->bindValue(':filtro', '%' . $filtro . '%');
                $stmt->execute();
                if ($stmt->rowCount()) {
                    return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar matéria-prima: ' . $e->getMessage();
                return false;
            }
        }

        public function consultarPorId($id): MateriaPrima|bool {
            $cx = $this->cx();
            $stmt = $cx->prepare("SELECT * FROM materia_prima WHERE id = :id");
            try {
                $stmt->bindParam(':id', $id);
                if ($stmt->execute()) {
                    $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
                    return $stmt->fetch();
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao selecionar matéria-prima: ' . $e->getMessage();
                return false;
            }
        }

        public function deletar($id): bool {
            $cx = $this->cx();
            $stmt = $cx->prepare("DELETE FROM materia_prima WHERE id = :id");
            try {
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    return true;
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao deletar matéria-prima: ' . $e->getMessage();
                return false;
            }
        }

        public function alterar($id, array $dados): MateriaPrima|bool {
            $cx = $this->cx();
            $cmd = 'UPDATE materia_prima SET';
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
                if ($stmt->rowCount() > 0) {
                    return $this->consultarPorId($id);
                }
                return false;
            } catch (\PDOException $e) {
                $this->erro = 'Erro ao alterar matéria-prima: ' . $e->getMessage();
                return false;
            }
        }
    }

// View ****************************************************************************************************************************************
    function MateriaPrima_res_get(Response $res, $dados, $erro) {
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

    function MateriaPrima_res_post(Response $res, $dados, $erro) {
        $status = 0;
        $success = [
            "data" => $dados,
            "code" => 202
        ];
        $error = [
            "message" => $erro ? $erro : "Não foi possível cadastrar matéria-prima",
            "code" => $erro ? 500 : 404
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

    function MateriaPrima_res_put(Response $res, $dados, $erro) {
        $status = 0;
        $success = [
            "data" => $dados,
            "code" => 200
        ];
        $error = [
            "message" => $erro ? $erro : "Não foi possível alterar matéria-prima",
            "code" => $erro ? 500 : 404
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

    function MateriaPrima_res_delete(Response $res, $return, $erro) {
        $status = 0;
        $success = [
            "data" => [],
            "code" => 204
        ];
        $error = [
            "message" => $erro ? $erro : "Recurso não encontrado",
            "code" => $erro ? 500 : 404
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
        $app->get('/materia_prima', function (Request $req, Response $res, $args) {
            $materiaPrima = new MateriaPrima();
            $search = $req->getQueryParams();
            if (count($search) == 0) {
                $materiasPrimas = $materiaPrima->consultarTodos();
            } elseif (isset($search['nome'])) {
                $materiasPrimas = $materiaPrima->consultarTodos($search['nome']);
            } else {
                $materiaPrima->setErro("Query string inválida");
                $materiasPrimas = false;
            }
            return MateriaPrima_res_get($res, $materiasPrimas, $materiaPrima->getErro());
        });

        $app->get('/materia_prima/{id}', function (Request $req, Response $res, $args) {
            $materiaPrima = new MateriaPrima();
            $materiaPrimaItem = $materiaPrima->consultarPorId($args['id']);
            return MateriaPrima_res_get($res, $materiaPrimaItem, $materiaPrima->getErro());
        });

    // POST
        $app->post('/materia_prima', function (Request $req, Response $res, $args) {
            $materiaPrima = new MateriaPrima();
            $body = $req->getBody();
            $dados = json_decode($body, true);
            foreach ($dados as $chave => $valor) {
                $materiaPrima->$chave = $valor;
            }
            $materiaPrimaItem = $materiaPrima->cadastrar();
            return MateriaPrima_res_post($res, $materiaPrimaItem, $materiaPrima->getErro());
        });

    // DELETE
        $app->delete('/materia_prima/{id}', function (Request $req, Response $res, $args) {
            $materiaPrima = new MateriaPrima();
            $result = $materiaPrima->deletar($args['id']);
            return MateriaPrima_res_delete($res, $result, $materiaPrima->getErro());
        });

    // Alterar
        $app->patch('/materia_prima/{id}', function (Request $req, Response $res, $args) {
            $materiaPrima = new MateriaPrima();
            $body = $req->getBody();
            $dados = json_decode($body, true);
            $materiaPrimaItem = $materiaPrima->alterar($args['id'], $dados);
            return MateriaPrima_res_put($res, $materiaPrimaItem, $materiaPrima->getErro());
        });