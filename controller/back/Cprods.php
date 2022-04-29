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
      header('Location: ' . $_SESSION['INDEX_PATH'] . 'controller/back/BCcontrol.php?menu=6&lang=' . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
    }
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
        $articuloDAO->addElement($values);
        header("Location: " . $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=6&lang=" . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
      } catch (PDOException $ex) {
        echo $ex->getMessage();
        echo $ex->getTrace();
        $location = $_SESSION['INDEX_PATH'] . 'view/back/Usuario/BVUsuariofail.php?lang=' . $_GET['lang'] . '&ex=' . $ex->getMessage() . '&idTarifa=' . $_GET['idTarifa'];
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
      header('Location: ' . $_SESSION['INDEX_PATH'] . 'BCcontrol.php?menu=6&lang=' . $_SESSION['lang'] . "&idTarifa=" . $_GET['idTarifa']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    areUAllowed([3]);
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=6&lang=' . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
    }
    $id = $_GET['id'];
    $campos = $articuloDAO->searchRow($id);
    $imagenes = $articuloDAO->getImages($id);
    if (isset($_POST['submit'])) {
      try {
        if(isset($_POST['preloaded']))
        $values = [
          "nombre" => $_POST['name'],
          "descripcionCorta" => $_POST['descripcion'],
          "descripcionLarga" => $_POST['descripcion2'],
          "marca" => $_POST['marca'],
          "categoria" => $_POST['categoria'],
          "subcategoria" => $_POST['subcategoria'],
          "coste" => $_POST['coste'],
          "files" => $_FILES,
          "f_preloaded" => $_POST['preloaded']
        ];
        else
        $values = [
          "nombre" => $_POST['name'],
          "descripcionCorta" => $_POST['descripcion'],
          "descripcionLarga" => $_POST['descripcion2'],
          "marca" => $_POST['marca'],
          "categoria" => $_POST['categoria'],
          "subcategoria" => $_POST['subcategoria'],
          "coste" => $_POST['coste'],
          "files" => $_FILES,
          "f_preloaded" => false
        ];
        print_r($values['files']);
        print_r($values['f_preloaded']);
        $articuloDAO->update($id, $values);
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
