<?php
spl_autoload_register(function ($class) {
    $file = $class . '.php';
    var_dump($file);
    if (file_exists($file)) {        
        require_once $file;
        return;
    }
});