<?php
require_once $paths['Estandar'];
require_once $paths['DAO'];
require_once $paths['MarcaDAO'];
require_once $paths['CategoriaDAO'];
require_once $paths['SubcategoriaDAO'];
require_once $paths['IvaDAO'];
require_once $paths['Articulo'];
class ArticuloDAO extends Estandar implements DAO
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection, 'articulo');
    }
    public function addElement(array $values): void
    {
        $campos = ['nombre'];
        parent::insert($campos, $values, array());
    }

    public function getList(): array
    {
        $articuloArray = parent::getAll();
        $articuloList = array_fill(0, sizeof($articuloArray), null);
        $marcaDAO = new MarcaDAO(parent::getDB());
        $categoriaDAO = new CategoriaDAO(parent::getDB());
        $subcategoriaDAO = new SubcategoriaDAO(parent::getDB());
        $ivaDAO = new IvaDAO(parent::getDB());
        for ($i=0; $i < sizeof($articuloList); $i++){  
                array_push($articuloList, new Articulo([
                'idArticulo' => $articuloArray['idArticulo'],
                'nombre' => $articuloArray['nombre'],
                'descripcionCorta' => $articuloArray['descripcionCorta'],
                'descripcionLarga' => $articuloArray['descripcionLarga'],
                'marca' => $marcaDAO->searchRow($articuloArray['marca']),
                'categoria' => $categoriaDAO->searchRow($articuloArray['articulo']),
                'subcategoria' => $subcategoriaDAO->searchRow($articuloArray['subcategoria']),
                'iva' => $ivaDAO->searchRow($articuloArray['iva']),
                'stock' => $articuloArray['stock']
            ]));
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
}
