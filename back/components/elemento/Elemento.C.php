<?php

switch($method){
    case "GET":{        
        $result = [
            "path"=>"elemento",
            "status"=>"ok"
        ];
        echo json_encode($result);
    }break;
    case "POST":{
        
    }break;
    case "DELETE":{

    }break;
    case "PUT":{

    }break;
    case "PATCH":{

    }break;
    default:{     
        $code_status = 500;
        $result = [
            "sucesso" => false,
            "erro" => "Método não suportado",
            "dados" => ""
        ];
        
    }break;
}
