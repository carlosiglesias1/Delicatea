<?php
require_once($_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php');
class Categorias extends Estandar
{

    public function __construct()
    {
        parent::__construct('categoria');
    }

    public function newCategorie()
    {
        $campos = ['nombre', 'descripcion'];
        $valores = array(
            "name" => $_POST['name'],
            "password" => $_POST['descripcion']
        );
        $valor = $this->exists($valores['name']);
        if ($valor == 0) {
            parent::insert($campos, $valores);
            header("Location: BCcontrol.php?menu=5&lang=es");
        } else {
            header("Location: " . $_SESSION['INDEX_PATH'] . "Back/Vistas/Usuario/BVUsuariofail.php");
        }
    }

    public function updateCat(int $id)
    {
        $campos = array(
            "nombre" => $_POST['name'],
            "descripcion" => $_POST['descripcion']
        );
        $string = concatenar($campos);
        return parent::updateItem($string, 'idCategoria', $id);
    }

    public function getByID(int $id)
    {
        return parent::getBy('idCategoria', $id, PDO::PARAM_INT);
    }

    public function getByName($name)
    {
        return parent::getBy('nombre', $name, PDO::PARAM_STR);
    }



    public function deleteByID($id)
    {
        return parent::deleteBy('idCategoria', $id);
    }

    private function exists($name)
    {
        return parent::existsBy('nombre', "'" . $name . "'");
    }
}
