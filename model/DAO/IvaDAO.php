<?php
require_once ($_SESSION['WORKING_PATH'] . 'model/Mestandar.php');
class IvaDAO extends Estandar implements DAO{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn, 'tiposiva');
    }

    public function addElement()
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

    public function getList():array
    {
        $array = parent::getAll();
        $list = array_fill(0, sizeof($array), NULL);
        for ($i = 0; $i < sizeof($array); $i++) {
            $list[$i] = new IVA($array[$i]);
        }
        return $list;
    }

    public function update()
    {
        # code...
    }

    public function searchRow()
    {
        # code...
    }
}