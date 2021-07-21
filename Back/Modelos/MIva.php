<?php
require_once($_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php');
class IVA extends Estandar
{

    public function __construct()
    {
        parent::__construct('tiposiva');
    }

    public function newUser()
    {
        $campos = ['tipo', 'pass'];
        $valores = array(
            "tiponame" => $_POST['tiponame'],
            "password" => hash("sha512", $_POST['password'])
        );
        $valor = $this->exists($valores['tiponame']);
        if ($valor == 0) {
            parent::insert($campos, $valores);
            header("Location: BCcontrol.php?menu=1&lang=es");
        } else {
            header("Location: " . $_SESSION['INDEX_PATH'] . "Back/Vistas/Usuario/BVUsuariofail.php");
        }
    }

    public function updateIVa(string $id)
    {
        $campos = array(
            "tipo" => $_POST['tipo'],
            "porcentage" => $_POST['porcentage']
        );
        $string = concatenar($campos);
        return parent::update($string, 'idIva', $id);
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
