<?php
require_once $_SESSION['WORKING_PATH'] . "conection/ConnectionPool.php";
require_once $_SESSION['WORKING_PATH'] . "model/DAO/UsuarioDAO.php";
class MySQLDAOFactory
{
    private $bcp;

    public function __construct()
    {
        $this->bcp = ConnectionPool::create();
    }

    public function getUsuarioDAO(): UsuarioDAO
    {
        return new UsuarioDAO($this->bcp->getConnection());
    }

    /**
     * Get the value of bcp
     */ 
    public function getBcp()
    {
        return $this->bcp;
    }
}
