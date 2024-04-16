<?php
spl_autoload_register(function ($class) {
    $file = $class . '.php';
    if (file_exists($file)) {
        var_dump($file);
        require_once $file;
        return;
    }
});