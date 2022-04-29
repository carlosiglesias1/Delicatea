<?php
require_once $_SESSION['WORKING_PATH'] . 'model/Mestandar.php';
require_once $_SESSION['WORKING_PATH'] . 'model/Classes/Articulo.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/DAO.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/factory/MySQLDAOFactory.php';
class ArticuloDAO extends Estandar implements DAO
{
  private $factory;
  private $marcaDAO;
  private $categoriaDAO;
  private $subcategoriaDAO;
  private $ivaDAO;
  private $tipos = [
    'nombre' => PDO::PARAM_STR,
    'descripcionCorta' => PDO::PARAM_STR,
    'descripcionLarga' => PDO::PARAM_STR,
    'marca' => PDO::PARAM_INT,
    'categoria' => PDO::PARAM_INT,
    'subcategoria' => PDO::PARAM_INT,
    //'iva' => PDO::PARAM_INT,
    'stock' => PDO::PARAM_INT,
    'coste' => PDO::PARAM_INT
  ];
  public function __construct(PDO $connection)
  {
    parent::__construct($connection, 'articulo');
    $this->factory = new MySQLDAOFactory();
    $this->marcaDAO = $this->factory->getMarcaDAO();
    $this->categoriaDAO = $this->factory->getCategoriaDAO();
    $this->subcategoriaDAO = $this->factory->getSubcategoriaDAO();
    $this->ivaDAO = $this->factory->getIvaDAO();
  }
  public function addElement(array $values): void
  {
    $files = $values['files'];
    unset($values['files']);
    parent::insert(array_keys($this->tipos), $values, array_values($this->tipos));
    $this->insertImages($files);
  }

  public function getList(): array
  {
    $articuloArray = parent::getAll();
    $articuloList = array();
    for ($i = 0; $i < sizeof($articuloArray); $i++) {
      array_push(
        $articuloList,
        $this->instanciarArticulo($articuloArray[$i])
      );
    }
    return $articuloList;
  }

  public function update(int $id, array $valores): void
  {
    foreach ($valores as $key => $value) {
      parent::updateValue($key, $value, $this->tipos[$key], 'idArticulo', $id);
    }
  }

  public function searchRow(int $id): Articulo
  {
    return $this->instanciarArticulo(parent::getBy('idArticulo', $id, PDO::PARAM_INT));
  }

  public function delete(int $id)
  {
    parent::deleteBy('idArticulo', $id, PDO::PARAM_INT);
    parent::foreignDelete('imagenesArticulos', 'articulo', $id);
  }

  public function instanciarArticulo(array $values): Articulo
  {
    return new Articulo(
      [
        'idArticulo' => $values['idArticulo'],
        'nombre' => $values['nombre'],
        'descripcionCorta' => $values['descripcionCorta'],
        'descripcionLarga' => $values['descripcionLarga'],
        'marca' => $this->marcaDAO->searchRow($values['marca']),
        'categoria' => $this->categoriaDAO->searchRow($values['categoria']),
        'subcategoria' => $this->subcategoriaDAO->searchRow($values['subcategoria']),
        'iva' => $this->ivaDAO->searchRow($values['iva']),
        'stock' => 1,
        'coste' => $values['coste']
      ]
    );
  }

  public function insertImages(array $files)
  {
    $_FILES = $files;
    $idArticulo = parent::getLastId('idArticulo');
    $directorio = $_SESSION['WORKING_PATH'] . "imgs/articulos/$idArticulo";
    $src = $_SESSION['INDEX_PATH'] . "imgs/articulos/$idArticulo";
    require_once($_SESSION['WORKING_PATH'] . "Funciones/uploader.php");
    if ($handler = opendir($directorio)) {
      while (false !== ($file = readdir($handler))) {
        if ($file != "." && $file != "..") {
          $this->foreignInsert('imagenesArticulos', ["path", "articulo"], ["path" => "$src/$file", "articulo" => $idArticulo]);
        }
      }
    }
  }
}
