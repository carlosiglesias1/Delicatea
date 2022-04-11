<?php
require_once($_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php');
class IVA extends Estandar
{

    public function __construct(PDO $conn)
    {
        parent::__construct($conn, 'tiposiva');
    }

    public function newIVA()
    {
        
    }

    public function updateIVa(string $id)
    {
        $campos = array(
            "tipo" => $_POST['tipo'],
            "porcentage" => $_POST['porcentage'],
            "recargoEquivalencia"=> $_POST['recargo']
        );
        $string = concatenar($campos);
        return parent::updateItem($string, 'idIva', $id);
    }

    public function getByID($id)
    {
        return parent::getBy('idIva', $id);
    }

    public function getByName(string $name)
    {
        return parent::getBy('tipo', "'" . $name . "'");
    }

    public function deleteByID($id)
    {
        return parent::deleteBy('idIva', $id);
    }

    private function exists($tipo)
    {
        return parent::existsBy('tipo', "'" . $tipo . "'");
    }
}
