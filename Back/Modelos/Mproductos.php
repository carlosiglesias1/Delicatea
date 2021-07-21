<?php
require_once($_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php');
class Articulo extends Estandar
{

    public function __construct()
    {
        parent::__construct('articulo');
    }

    public function newArticle()
    {
        $campos = ['nombre', 'descripcionCorta', 'descripcionLarga'];
        $valores = array(
            "nickname" => $_POST['name'],
            "descripcion" =>  $_POST['descripcion'],
            "description2" => $_POST['descripcion2']
        );
        $valor = $this->exists($valores['name']);
        if ($valor == 0) {
            parent::insert($campos, $valores);
            header("Location: BCcontrol.php?menu=6&lang=es");
        } else {
            header("Location: " . $_SESSION['INDEX_PATH'] . "Back/Vistas/Usuario/BVUsuariofail.php");
        }
    }

    public function updateArticle(int $id)
    {
        $campos = array(
            "nombre" => $_POST['name'],
            "descripcionCorta" =>  $_POST['descripcion'],
            "descripcionLarga" => $_POST['descripcion2']
        );
        $string = concatenar($campos);
        return parent::update($string, 'idArticulo', $id);
    }

    public function getByID($id)
    {
        return parent::getBy('idArticulo', $id);
    }

    public function getByName($name)
    {
        return parent::getBy('nombre', "'" . $name . "'");
    }

    public function deleteByID($id)
    {
        return parent::deleteBy('idArticulo', $id);
    }

    private function exists($nickname)
    {
        return parent::existsBy('nombre', "'" . $nickname . "'");
    }
}
