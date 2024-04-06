<?php
session_start();
if(isset($_SESSION['user_logado'])){
    require_once("front/index.php");
}
else{
    //require_once("front/login.php");
    require_once("front/index.php");
}
// Por enquanto ainda não criei o controle de login (session_start()) no back-end