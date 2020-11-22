<?php
    // Autoloader
    spl_autoload_register(function ($class) {
        include __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    });

    session_set_cookie_params(600,"/");
    session_start();

    $app = new \Core\App();
    $app->run();