<?php
return [
    'pool_size' => 3,
    'max_pool_size' => 10,
    'host' => 'localhost:3320',
    'user' => 'root',
    'pass' => '',
    'db_name' => 'delicatea',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 1000,
    ],
];