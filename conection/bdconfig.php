<?php
return array(
    'pool_size' => 3,
    'max_pool_size' => 5,
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'db_name' => 'delicatea',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => FALSE,
        PDO::ATTR_TIMEOUT =>1000
    ]
);
