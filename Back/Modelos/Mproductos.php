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
        //$campos = ['nombre', 'descripcionCorta', 'descripcionLarga', 'codigo', 'sku', 'pn', 'marca', 'categoria', 'subcategoria', 'coste', 'iva', 'puntoVerde', 'impuestoAlcochol'];
        $campos = ['nombre', 'descripcionCorta', 'descripcionLarga', 'marca', 'categoria', 'subcategoria', 'coste'];
        $valores = array(
            "nickname" => $_POST['name'],
            "descripcion" =>  $_POST['descripcion'],
            "description2" => $_POST['descripcion2'],
            /*"codigo" => $_POST['codigo'],
            "sku" => $_POST['sku'],
            "pn" => $_POST['pn'],/*/
            "marca" => $_POST['marca'],
            "categoria" => $_POST['categoria'],
            "subcategoria" => $_POST['subcategoria'],
            "coste" => $_POST['coste'],
            /*"iva" => $_POST['iva'],
            "puntoVerde" => $_POST['puntoVerde'],
            "impuestoAlcochol" => $_POST['impuestoAlcohol']*/
        );
        $valor = $this->exists($valores['nickname']);
        if ($valor == 0)
            parent::insert($campos, $valores);
    }

    public function updateArticle(int $id)
    {
        $campos = array(
            "nombre" => $_POST['name'],
            "descripcionCorta" => $_POST['descripcion'],
            "descripcionLarga" => $_POST['descripcion2'],
            /*"codigo" => $_POST['codigo'],
            "sku" => $_POST['sku'],
            "pn" => $_POST['pn'],*/
            "marca" => $_POST['marca'],
            "categoria" => $_POST['categoria'],
            "subcategoria" => $_POST['subcategoria'],
            "coste" => $_POST['coste'],
            /*"iva" => $_POST['iva'],
            "puntoVerde" => $_POST['puntoVerde'],
            "impuestoAlcochol" => $_POST['impuestoAlcohol']*/
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
