<?php
<<<<<<< HEAD
require_once $_SESSION['WORKING_PATH'].'Back/Modelos/Mestandar.php';
    class SubcategoriaDAO extends Estandar implements DAO{
        public function getList(): array
        {
            $array = parent::getAll();
        }
        public function searchRow(int $id)
        {
            
        }
        public function update(int $id, array $valores): void
        {
            
        }
        public function delete(int $id)
        {
            
        }
        public function deleteAll()
        {
            
        }
    }
=======
require_once $_SESSION['WORKING_PATH']."Back/Modelos/Mestandar.php";
require_once $_SESSION['WORKING_PATH']."Back/Modelos/DAO/DAO.php";
require_once $_SESSION['WORKING_PATH']."Back/Modelos/Classes/Subcategoria.php";
class SubcategoriaDAO extends Estandar implements DAO
{
    public function __construct()
    {
        parent::__construct('subcategoria');
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
>>>>>>> 96085a3b29d3f29d3941299df19084de1ef44b8a
