<?php
require_once($_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php');
require_once $_SESSION['WORKING_PATH'] ."Back/Modelos/DAO/DAO.php";
require_once($_SESSION['WORKING_PATH'] . "Back/Modelos/Classes/Marca.php");
class MarcaDAO extends Estandar implements DAO
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection, 'marcas');
    }

    public function addElement(array $valores):void
    {
        $campos = ['nombre'];
        $tipos = [PDO::PARAM_STR];
        $valor = $this->exists($valores['name']);
        if ($valor == 0) {
            parent::insert($campos, $valores, $tipos);
            header("Location: BCcontrol.php?menu=2&lang=es");
        } else {
            header("Location:  " . $_SESSION['INDEX_PATH'] . "Back/Vistas/Usuario/BVUsuariofail.php");
        }
    }

    public function searchRow(int $id)
    {
        return new Marca(parent::getBy('idMarca', $id, PDO::PARAM_INT));
    }

    public function searchByName(string $name)
    {
        return parent::getBy('nombre', $name, PDO::PARAM_STR);
    }

    public function getList():array
    {
        $array = parent::getAll();
        $list = array_fill(0, sizeof($array), NULL);
        for ($i = 0; $i < sizeof($array); $i++) {
            $list[$i] = new Marca($array[$i]);
        }
        return $list;
    }

    public function update(int $id, array $valores):void
    {
        $camposYTipos = [
            "nombre" => PDO::PARAM_STR
        ];
        foreach ($camposYTipos as $campo => $tipo) {
            parent::updateValue($campo, $valores[$campo], $tipo, "idMarca", $id);
        }
    }

    public function delete(int $id)
    {
        parent::deleteBy('idMarca', $id, PDO::PARAM_INT);
    }

    private function exists(string $name)
    {
        return parent::existsBy('nombre', $name, PDO::PARAM_STR);
    }
}
