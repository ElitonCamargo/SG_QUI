<?php
class View{
    function res($code_status, $result){
        http_response_code($code_status);
        echo json_encode($result);
    }
}