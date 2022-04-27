<?php
require_once $_SESSION['WORKING_PATH'] . 'model/Mestandar.php';
require_once $_SESSION['WORKING_PATH'] . 'model/Classes/Articulo.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/DAO.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/factory/MySQLDAOFactory.php';
class ArticuloDAO extends Estandar implements DAO
{
  private $factory;
  public function __construct(PDO $connection)
  {
    parent::__construct($connection, 'articulo');
    $this->factory = new MySQLDAOFactory();
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
    $articuloList = array();
    $marcaDAO = $this->factory->getMarcaDAO();
    $categoriaDAO = $this->factory->getCategoriaDAO();
    $subcategoriaDAO = $this->factory->getSubcategoriaDAO();
    $ivaDAO = $this->factory->getIvaDAO();
    for ($i = 0; $i < sizeof($articuloArray); $i++) {
      array_push(
        $articuloList,
        new Articulo([
          'idArticulo' => $articuloArray[$i]['idArticulo'],
          'nombre' => $articuloArray[$i]['nombre'],
          'descripcionCorta' => $articuloArray[$i]['descripcionCorta'],
          'descripcionLarga' => $articuloArray[$i]['descripcionLarga'],
          'marca' => $marcaDAO->searchRow($articuloArray[$i]['marca']),
          'categoria' => $categoriaDAO->searchRow($articuloArray[$i]['categoria']),
          'subcategoria' => $subcategoriaDAO->searchRow($articuloArray[$i]['subcategoria']),
          'iva' => $ivaDAO->searchRow($articuloArray[$i]['iva']),
          'stock' => 1,
          'coste' => $articuloArray[$i]['coste']
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

  public function getLastArticulo(): int
  {
    return parent::getLastId('idArticulo');
  }
}
