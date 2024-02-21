<?php

return [
    'port' => 'mysql',
    'host' => 'localhost',
    'dbname' => 'SystemProductsWarehouses',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::MYSQL_ATTR_INIT_COMMAND => "Set names 'utf8'",
    ],
];
