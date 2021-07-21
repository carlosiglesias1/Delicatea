<?php
require_once($_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php');
class Marcas extends Estandar
{
    public function __construct()
    {
        parent::__construct('marca');
    }

    public function getById(int $id)
    {
        return parent::getBy('idMarca', $id);
    }

    public function getByName(string $name)
    {
        parent::getBy('nombre', "'" . $name . "'");
    }

    public function getAll(){
        return parent::getAll();
    }

    public function NewMark()
    {
        $campos = ['nombre'];
        $valores = array(
            "name" => $_POST['name'],
        );
        $valor = $this->exists($valores['name']);
        if ($valor == 0) {
            parent::insert($campos, $valores);
            header("Location: BCcontrol.php?menu=2&lang=es");
        } else {
            header("Location:  " . $_SESSION['INDEX_PATH'] . "Back/Vistas/Usuario/BVUsuariofail.php");
        }
    }

    public function updateMark(int $id)
    {
        $campos = array(
            "nombre"=>$_POST['name']
        );
        $string = concatenar($campos);
        return parent::update($string, 'idMarca', $id);
    }

    public function deleteById(int $id){
        parent::deleteBy('idMarca', $id);
    }

    private function exists(string $name)
    {
        return parent::existsBy('nombre', "'" . $name . "'");
    }
}
