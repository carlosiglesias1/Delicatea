<?php
require_once $_SESSION['WORKING_PATH'] . "conection/ConnectionPool.php";

class MySQLDAOFactory
{
    private $bcp;

    public function __construct()
    {
        $this->bcp = ConnectionPool::getInstance();
    }

    public function getUsuarioDAO(): UsuarioDAO
    {
        require_once $_SESSION['WORKING_PATH'] . "model/DAO/UsuarioDAO.php";
        return new UsuarioDAO($this->bcp->getConnection());
    }

    public function getMarcaDAO(): MarcaDAO
    {
        require_once $_SESSION['WORKING_PATH'] . "model/DAO/MarcaDAO.php";
        return new MarcaDAO($this->bcp->getConnection());
    }

    public function getSubcategoriaDAO():SubcategoriaDAO
    {
        require_once $_SESSION['WORKING_PATH'] . "model/DAO/SubcategoriaDAO.php";
        return new SubcategoriaDAO($this->bcp->getConnection());
    }

    public function getCategoriaDAO(): CategoriaDAO
    {   
        require_once $_SESSION['WORKING_PATH'] . "model/DAO/CategoriaDAO.php";
        return new CategoriaDAO($this->bcp->getConnection());
    }

    public function getIvaDAO(): IvaDAO{
        require_once $_SESSION['WORKING_PATH']. "model/DAO/IvaDAO.php";
        return new IvaDAO($this->bcp->getConnection());
    }

    /**
     * Get the value of bcp
     */
    public function getBcp()
    {
        return $this->bcp;
    }
}
