<?php
class MySQLDAOFactory
{
    static $bcp;

    public function __construct()
    {
        $this->bcp = ConnectionPool::create();
    }

    public function getUsuarioDAO(): UsuarioDAO
    {
        return new UsuarioDAO($this->bcp->getConnection());
    }
}
