<?php
require_once $_SESSION['WORKING_PATH']."model/Mestandar.php";
require_once $_SESSION['WORKING_PATH']."model/DAO/DAO.php";
require_once $_SESSION['WORKING_PATH']."model/Classes/Subcategoria.php";
class SubcategoriaDAO extends Estandar implements DAO
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection,'subcategoria');
    }
    public function addElement(array $valores): void
    {
        $campos = ["nombre", "descripcion", "categoria"];
        $tipos = [PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT];
        if ($this->exists($valores[0]) == 0) {
            parent::insert($campos, $valores, $tipos);
            header("Location: BCcontrol.php?menu=4&lang=es&idCat=0");
        }
    }
    public function getList(): array
    {
        $array = parent::getAll();
        $list = array_fill(0, sizeof($array), NULL);
        for ($i = 0; $i < sizeof($array); $i++) {
            $list[$i] = new Subcategoria($array[$i]);
        }
        return $list;
    }
    public function update(int $id, array $valores): void
    {
        $camposYTipos = [
            "nombre" => PDO::PARAM_STR,
            "descripcion" => PDO::PARAM_STR,
            "categoria" => PDO::PARAM_INT
        ];
        foreach ($camposYTipos as $campo => $tipo) {
            parent::updateValue($campo, $valores[$campo], $tipo, "idSubCategoria", $id);
        }
    }
    public function searchRow(int $id)
    {
        return new SubCategoria(parent::getBy("idSubCategoria", $id, PDO::PARAM_INT));
    }
    public function delete(int $id)
    {
        parent::deleteBy("idSubCategoria", $id, PDO::PARAM_STR);
    }
    public function exists(string $name)
    {
        return parent::existsBy("nombre", $name, PDO::PARAM_STR);
    }
}
