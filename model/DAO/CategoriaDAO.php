<?php
require_once $_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php';
require_once 'DAO.php';
require_once $_SESSION['WORKING_PATH'] . 'Back/Modelos/Classes/Categoria.php';
class CategoriaDAO extends Estandar implements DAO
{

    public function __construct()
    {
        parent::__construct('categoria');
    }
    public function addElement(array $valores): void
    {
        $campos = ["nombre", "descripcion"];
        $valor = $this->exists($valores["nombre"]);
        if ($valor == 0) {
            parent::insert($campos, $valores, [PDO::PARAM_STR, PDO::PARAM_STR]);
            header('Location: BCcontrol.php?menu=4&lang=es');
        }
    }

    public function getList(): array
    {
        $matrix = parent::getAll();
        $lista = array_fill(0, sizeof($matrix), 0);
        for ($i = 0; $i < sizeof($lista); $i++) {
            $lista[$i] = new Categoria($matrix[$i]);
        }
        return $lista;
    }

    public function update(int $id, array $valores): void
    {
        $camposYTipos = [
            "nombre" => PDO::PARAM_STR,
            "descripcion" => PDO::PARAM_STR
        ];
        foreach ($camposYTipos as $campo => $tipo) {
            parent::updateValue($campo, $valores[$campo], $tipo, "idUsr", $id);
        }
    }
    public function searchRow(int $id)
    {
        return parent::getBy('idCategoria', $id, PDO::PARAM_INT);
    }
    public function delete(int $id)
    {
        parent::deleteBy('idCategoria', $id, PDO::PARAM_INT);
    }
    public function getSubcategorias($idCategoria)
    {
        require_once $_SESSION['WORKING_PATH'] . 'Back/Modelos/Classes/Subcategoria.php';
        $array = parent::getForeignValue("subcategoria", null, $idCategoria, "categoria");
        $list = array_fill(0, sizeof($array), NULL);
        for ($i = 0; $i < sizeof($array); $i++) {
            $list[$i] = new Subcategoria($array[$i]);
        }
        return $list;
    }
    public function exists($nombre)
    {
        return parent::existsBy("nombre", $nombre, PDO::PARAM_STR);
    }
}