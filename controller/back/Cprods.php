<?php
ob_start();

require_once("../../paths/AbsolutePaths.php");
require_once($_SESSION['WORKING_PATH'] . "view/back/cabecera.php");
require_once($_SESSION['WORKING_PATH'] . "Funciones/funciones.php");
require_once($_SESSION['WORKING_PATH'] . "model/DAO/factory/MySQLDAOFactory.php");

$articuloDAO = new MySQLDAOFactory();
$articuloDAO = $articuloDAO->getArticuloDAO();

$menu = $_GET['menu'];
switch ($menu) {
  case 1:
    areUAllowed([3]);
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=6&lang=' . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
    }
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    if (isset($_POST['submit'])) {
      try {
        $values = [];
        $idArticulo = $articuloDAO->addElement($values);
        $directorio = $_SESSION['WORKING_PATH'] . "imgs/articulos/$idArticulo";
        $src = $_SESSION['INDEX_PATH'] . "imgs/articulos/$idArticulo";
        require_once($_SESSION['WORKING_PATH'] . "Funciones/uploader.php");
        if ($handler = opendir($directorio)) {
          while (false !== ($file = readdir($handler))) {
            if ($file != "." && $file != "..") {
              //$articulo->foreignInsert('imagenesArticulos', ["path" => "path", "idArticulo" => "articulo"], ["$src/$file", $idArticulo]);
            }
          }
        }
        closedir($handler);
        header("Location: " . $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=6&lang=" . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
      } catch (PDOException $ex) {
        $location = $_SESSION['INDEX_PATH'] . 'Back/Vistas/Usuario/BVUsuariofail.php?lang=' . $_GET['lang'] . "&ex=" . $ex . "&idTarifa=" . $_GET['idTarifa'];
        echo $location;
        header('Location: ' . $location);
      }
    }
    require_once("../../view/back/Productos/VCrearProd.php");
    break;

  case 2:
    require_once("../cabecera.php");
    areUAllowed([3]);
    require_once("../Modelos/Mproductos.php");
    $articulo = new Articulo('articulo');
    $selected = unserialize($_GET['selected']);
    try {
      foreach ($selected as $fila) {
        $articulo->deleteByID($fila);
        $articulo->foreignDelete('imagenesArticulos', 'articulo', $fila);
      }
      header('Location: BCcontrol.php?menu=6&lang=' . $_SESSION['lang'] . "&idTarifa=" . $_GET['idTarifa']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    require_once("../cabecera.php");
    areUAllowed([3]);
    require_once("../Modelos/Mproductos.php");
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=6&lang=' . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
    }
    $articulo = new Articulo();
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    $id = $_GET['id'];
    $campos = $articulo->getByID($id);
    $imagenes = $articulo->getForeignValue('path', 'imagenesArticulos', $id, 'articulo');
    if (isset($_POST['submit'])) {
      try {
        $directorio = $directorio = $_SESSION['WORKING_PATH'] . "Back/Imagenes/Articulos/$id";
        require_once($_SESSION['WORKING_PATH'] . "Funciones/uploader.php");
        if (!empty($deleteDB)) {
          foreach ($deleteDB as $fila) {
            echo $fila;
            $articulo->foreignDelete('imagenesarticulos', 'path', "'" . $fila . "'");
          }
        }
        $src = $_SESSION['INDEX_PATH'] . "Back/Imagenes/Articulos/$id";
        if (!empty($insertDb)) {
          print_r($insertDb);
          foreach ($insertDb as $fila) {
            $articulo->foreignInsert('imagenesArticulos', ["path" => "path", "idArticulo" => "articulo"], ["$src/$fila", $id]);
          }
        }
        $articulo->updateArticle($id);
        header('Location: BCcontrol.php?menu=6&lang=' . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }
    require_once("../Vistas/Productos/VCrearProd.php");
    break;
  default:
    require_once("./BCcontrol.php");
    break;
}
ob_end_flush();
