<?php
class Conectar
{
    private $host, $user, $pass, $database;
    private $options;
    public function __construct()
    {
        $config = require_once 'bdconfig.php';
        $this->host = $config['host'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->database = $config['name'];
        $this->options = $config['options'];
    }

    public function conectar()
    {
        return new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database . '', $this->user, $this->pass, $this->options);
    }
}
