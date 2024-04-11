<?php
namespace App\View;

use Psr\Http\Message\ResponseInterface as Response;

class Composto_qui {
    public function res_get(Response $res, $dados, $erro) {
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

    public function res_post(Response $res, $dados, $elementos, $erro) {
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

    public function res_put(Response $res, $dados, $erro) {
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

    public function res_delete(Response $res, $return, $erro) {
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
}
