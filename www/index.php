<?php
    // Autoloader
    spl_autoload_register(function ($class) {
        include __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    });

    session_start();
    $app = new \Core\App();
    $app->run();