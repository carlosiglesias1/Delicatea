<?php
require_once($_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php');
class IVA extends Estandar
{

    public function __construct()
    {
        parent::__construct('tiposiva');
    }

    public function newIVA()
    {
        $campos = ['tipo', 'porcentage', 'recargoEquivalencia'];
        $valores = array(
            "tipo" => $_POST['tipo'],
            "porcentage" => $_POST['porcentage'],
            "recargo"=> $_POST['recargo']
        );
        $valor = $this->exists($valores['tipo']);
        if ($valor == 0) {
            parent::insert($campos, $valores);
            header("Location: BCcontrol.php?menu=7&lang=es");
        } else {
            header("Location: " . $_SESSION['INDEX_PATH'] . "Back/Vistas/Usuario/BVUsuariofail.php");
        }
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
