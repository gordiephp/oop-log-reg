<?php
session_start();

$GLOBALS['config'] = [
    'mysql' => [
        'database' => 'xxx',
        'login'    => 'xxx',
        'pass'     => 'xxx',
        'host'     => 'localhost'
        ],
    'session' = [
        'token_name' => 'token'
    ]
    ];

spl_autoload_register(function($class) {
    require_once 'classes/' . $class . '.php';
});

require_once 'functions.php';
