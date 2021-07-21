<?php
require_once($_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php');
class SubCategoria extends Estandar
{

    public function __construct()
    {
        parent::__construct('subcategoria');
    }

    public function newSubCat()
    {
        $campos = ['nombre', 'descripcion', 'categoria'];
        $valores = array(
            "name" => $_POST['name'],
            "password" =>  $_POST['descripcion'],
            "categoria" => $_POST['categoria']
        );
        $valor = $this->exists($valores['name']);
        if ($valor == 0) {
            parent::insert($campos, $valores);
            if ($_GET['idCat'] != 0)
                header('Location:' . $_SESSION['INDEX_PATH'] . 'Back/Controladores/Ccats.php?menu=4&lang=' . $_GET['lang'] . '&idCat=' . $_GET['idCat']);
            else
                header('Location:' . $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=4&lang=' . $_GET['lang'] . '&idCat=0');
        } else {
            header("Location: " . $_SESSION['INDEX_PATH'] . "Back/Vistas/Usuario/BVUsuariofail.php");
        }
    }

    public function updateSubcat(int $id)
    {
        $campos = array(
            "nombre" => $_POST['name'],
            "descripcion" => $_POST['descripcion'],
            "categoria" => $_POST['categoria']
        );
        $string = concatenar($campos);
        return parent::update($string, 'idSubCategoria', $id);
    }

    public function getByID($id)
    {
        return parent::getBy('idSubCategoria', $id);
    }

    public function getByName($name)
    {
        return parent::getBy('nombre', "'" . $name . "'");
    }

    public function deleteByID($id)
    {
        return parent::deleteBy('idSubcategoria', $id);
    }

    private function exists($nickname)
    {
        return parent::existsBy('nombre', "'" . $nickname . "'");
    }
}
