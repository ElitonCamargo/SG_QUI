<?php
spl_autoload_register(function ($class) {
    $file = str_replace('\\',DIRECTORY_SEPARATOR,$class);
    $file .= '.php';
    if (file_exists($file)) {        
        require_once $file;
        return;
    }
});