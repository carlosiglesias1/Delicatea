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
        $values = [
          "nombre" => $_POST['name'],
          "descripcionCorta" => $_POST['descripcion'],
          "descripcionLarga" => $_POST['descripcion2'],
          "marca" => $_POST['marca'],
          "categoria" => $_POST['categoria'],
          "subcategoria" => $_POST['subcategoria'],
          "coste" => $_POST['coste'],
          "files" => $_FILES
        ];
        //print_r($values['files']);
        $articuloDAO->addElement($values);
        closedir($handler);
        header("Location: " . $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=6&lang=" . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
      } catch (PDOException $ex) {
        $location = $_SESSION['INDEX_PATH'] . 'Back/Vistas/Usuario/BVUsuariofail.php?lang=' . $_GET['lang'] . "&ex=" . $ex . "&idTarifa=" . $_GET['idTarifa'];
        echo $location;
        header('Location: ' . $location);
      }
    }
    require_once("../../view/back/Productos/VCrearProd.php");
    break;

  case 2:
    areUAllowed([3]);
    $selected = unserialize($_GET['selected']);
    try {
      foreach ($selected as $fila) {
        $articuloDAO->delete($fila);
      }
      header('Location: BCcontrol.php?menu=6&lang=' . $_SESSION['lang'] . "&idTarifa=" . $_GET['idTarifa']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    areUAllowed([3]);
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=6&lang=' . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
    }
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    $id = $_GET['id'];
    $campos = $articuloDAO->searchRow($id);
    $imagenes = $articuloDAO->getForeignValue ('imagenesArticulos', 'path', 'articulo', $id);
    if (isset($_POST['submit'])) {
      try {
        $directorio = $directorio = $_SESSION['WORKING_PATH'] . "Back/Imagenes/Articulos/$id";
        require_once($_SESSION['WORKING_PATH'] . "Funciones/uploader.php");
        if (!empty($deleteDB)) {
          foreach ($deleteDB as $fila) {
            echo $fila;
            $articuloDAO->foreignDelete('imagenesarticulos', 'path', "'" . $fila . "'");
          }
        }
        $src = $_SESSION['INDEX_PATH'] . "Back/Imagenes/Articulos/$id";
        if (!empty($insertDb)) {
          print_r($insertDb);
          foreach ($insertDb as $fila) {
            $articuloDAO->foreignInsert('imagenesArticulos', ["path" => "path", "idArticulo" => "articulo"], ["$src/$fila", $id]);
          }
        }
        $articuloDAO->update($id, array());
        header('Location: BCcontrol.php?menu=6&lang=' . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }
    require_once("../../view/back/Productos/VCrearProd.php");
    break;
  default:
    require_once("./BCcontrol.php");
    break;
}
ob_end_flush();
