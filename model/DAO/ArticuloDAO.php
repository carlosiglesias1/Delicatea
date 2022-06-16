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
    print_r($values);
    parent::insert(array_keys($this->tipos), $values, array_values($this->tipos));
    $this->insertImages($files, parent::getLastId('idArticulo'));
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
    $files = $valores['files'];
    unset($valores['files']);
    $checkImages = $valores['f_preloaded'];
    unset($valores['f_preloaded']);
    foreach ($valores as $key => $value) {
      if ($key != 'files'){
        parent::updateValue($key, $value, $this->tipos[$key], 'idArticulo', $id);
      }
    }
    $this->deleteImages($id, $checkImages);
    $this->insertImages($files, $id);
  }

  public function searchRow(int $id): Articulo
  {
    return $this->instanciarArticulo(parent::getBy('idArticulo', $id, PDO::PARAM_INT));
  }

  public function delete(int $id)
  {
    parent::deleteBy('idArticulo', $id, PDO::PARAM_INT);
    $this->deleteImages($id);
    parent::foreignDelete('imagenesArticulos', 'articulo', $id);
    rmdir($_SESSION['WORKING_PATH'] . $id);
    parent::foreignDelete('tarifasproductos', 'idPrd', $id);
  }


  public function getImages(int $id): array
  {
    return parent::getForeignValue('imagenesArticulos', 'path', 'articulo', $id);
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

  public function deleteImages(int $id, array | bool $checkImages = false)
  {
    $imagenes = $this->getImages($id);
    if (!$checkImages) {
      if (!empty($imagenes)) {
        for ($i = 0; $i < sizeof($imagenes); $i++) {
          $deleteLink = $imagenes[$i]['path'];
          $deletePath = substr($deleteLink, strlen($_SESSION['INDEX_PATH']));
          $deletePath = $_SESSION['WORKING_PATH'] . $deletePath;
          if (unlink($deletePath)) {
            parent::foreignDelete('imagenesarticulos', 'path', "'" . $deleteLink . "'");
            echo "exito<br>";
          }
          echo $deletePath . "<br>";
        }
      }
    } else {
      foreach ($imagenes as $key => $value) {
        if (!in_array($key, $checkImages)) {
          $deleteLink = $value['path'];
          $deletePath = substr($deleteLink, strlen($_SESSION['INDEX_PATH']));
          $deletePath = $_SESSION['WORKING_PATH'] . $deletePath;
          if (unlink($deletePath)) {
            parent::foreignDelete('imagenesarticulos', 'path', "'" . $deleteLink . "'");
            echo "exito<br>";
          }
          echo $deletePath . "<br>";
        }
      }
    }
  }

  public function insertImages(array $files, int $idArticulo)
  {
    $_FILES = $files;
    $directorio = $_SESSION['WORKING_PATH'] . "imgs/articulos/$idArticulo";
    $src = $_SESSION['INDEX_PATH'] . "imgs/articulos/$idArticulo";
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
      if (isset($_FILES['images']['name'][$key])) {
        $filename = $_FILES['images']['name'][$key];
        $temporal = $tmp_name;
      }

      if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
      }

      if (file_exists($directorio . "/" . $filename)) {
        $contador = 1;
        if ($handler = opendir($directorio)) {
          while (false !== ($file = readdir($handler))) {
            if (substr($file, 0, 1) == "(" && substr($file, strpos($file, ")") + 1) == $filename) {
                $contador++;
            }
          }
          closedir($handler);
        }
        $target = "$directorio/(" . ($contador) . ")$filename";
      } else {
        $target = "$directorio/$filename";
      }

      if (move_uploaded_file($temporal, $target)) {
        echo "El archivo $filename ha sido subido <br>";
      } else {
        echo "Ha ocurrido un error";
      }
    }
    if ($handler = opendir($directorio)) {
      while (false !== ($file = readdir($handler))) {
        if ($file != "." && $file != ".." && parent::foreignExistsBy('imagenesarticulos','path', "$src/$file", PDO::PARAM_STR) == 0) {
          parent::foreignInsert('imagenesArticulos', ["path", "articulo"], ["path" => "$src/$file", "articulo" => $idArticulo]);
        }
      }
    }
    closedir($handler);
  }
}
