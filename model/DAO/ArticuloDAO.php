<?php
require_once $_SESSION['WORKING_PATH'] . 'model/Mestandar.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/DAO.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/MarcaDAO.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/CategoriaDAO.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/SubcategoriaDAO.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/IvaDAO.php';
require_once $_SESSION['WORKING_PATH'] . 'model/Classes/Articulo.php';
class ArticuloDAO extends Estandar implements DAO
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection, 'articulo');
    }
    public function addElement(array $values): void
    {
        $tipos = [
            "nombre" => PDO::PARAM_STR,
            "descripcionCorta" => PDO::PARAM_STR,
            "descripcionLarga" => PDO::PARAM_STR,
            "marca" => PDO::PARAM_INT,
            "categoria" => PDO::PARAM_INT,
            "subcategoria" => PDO::PARAM_INT,
            "coste" => PDO::PARAM_INT
        ];
        parent::insert(array_keys($tipos), $values, array_values($tipos));
    }

    public function getList(): array
    {
        $articuloArray = parent::getAll();
        $articuloList = array_fill(0, sizeof($articuloArray), null);
        $marcaDAO = new MarcaDAO(parent::getDB());
        $categoriaDAO = new CategoriaDAO(parent::getDB());
        $subcategoriaDAO = new SubcategoriaDAO(parent::getDB());
        $ivaDAO = new IvaDAO(parent::getDB());
        for ($i = 0; $i < sizeof($articuloList); $i++) {
            array_push(
                $articuloList,
                new Articulo([
                    'idArticulo' => $articuloArray['idArticulo'],
                    'nombre' => $articuloArray['nombre'],
                    'descripcionCorta' => $articuloArray['descripcionCorta'],
                    'descripcionLarga' => $articuloArray['descripcionLarga'],
                    'marca' => $marcaDAO->searchRow($articuloArray['marca']),
                    'categoria' => $categoriaDAO->searchRow(
                        $articuloArray['articulo']
                    ),
                    'subcategoria' => $subcategoriaDAO->searchRow(
                        $articuloArray['subcategoria']
                    ),
                    'iva' => $ivaDAO->searchRow($articuloArray['iva']),
                    'stock' => $articuloArray['stock'],
                ])
            );
        }
        return $articuloList;
    }

    public function update(int $id, array $valores): void
    {
        # code...
    }

    public function searchRow(int $id)
    {
        # code...
    }

    public function delete(int $id)
    {
        # code...
    }

    public function addProductImgs()
    {
        $idArticulo = parent::getLastId('idArticulo');
        
    }
}
