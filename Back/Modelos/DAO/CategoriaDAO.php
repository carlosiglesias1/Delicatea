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
        parent::getBy('idCategoria', $id, PDO::PARAM_INT);
    }
    public function delete(int $id)
    {
        parent::deleteBy('idCategoria', $id, PDO::PARAM_INT);
    }
    public function getSubcategorias($idCategoria)
    {
        return parent::getForeignValue("subcategoria", "nombre", $idCategoria, "categoria");
    }
}
