<?php
session_start();
$usuario = @unserialize(@$_SESSION['user_logado']);

if(isset($_SESSION['user_logado'])){
    require_once("front/index.php");
}
else{
    //require_once("front/login.php");
    require_once("front/index.php");
}
//comentário git
