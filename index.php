<?php
session_start();

var_dump(@unserialize(@$_SESSION['user_logado']));

if(isset($_SESSION['user_logado'])){
    require_once("front/index.php");
}
else{
    require_once("front/login.php");

}
