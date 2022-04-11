<?php
ob_start();

require_once("../../paths/AbsolutePaths.php");
require_once("../../view/back/cabecera.php");
require_once("../../model/DAO/factory/MySQLDAOFactory.php");
$factory = new MySQLDAOFactory();
$menu = $_GET['menu'];
switch ($menu) {

  case 1:
    areUAllowed([1]);
    $iva = $factory->getIvaDAO();
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=7&lang=' . $_GET['lang']);
    }
    $iva = new IVA();
    if (isset($_POST['submit'])) {
      $iva->newIVA();
    }
    require_once("../Vistas/IVA/VCrearIva.php");
    break;

  case 2:
    areUAllowed([1]);
    $iva = new IVA();
    $selected = unserialize($_GET['selected']);
    try {
      foreach ($selected as $fila) {
        $iva->deleteByID($fila);
      }
      header('Location: BCcontrol.php?menu=7&lang=' . $_SESSION['lang']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    areUAllowed([1]);
    require_once("../../Funciones/funciones.php");
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=7&lang=' . $_GET['lang']);
    }
    $iva = new IVA();
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    $id = $_GET['id'];
    $campos = $iva->getByID($id)->fetch(PDO::FETCH_ASSOC);
    if (isset($_POST['submit']))
      try {
        $iva->updateIva($id);
        header('Location: BCcontrol.php?menu=7&lang=' . $_GET['lang']);
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    require_once("../Vistas/IVA/VCrearIva.php");
    break;

  default:
    require_once("./BCcontrol.php");
    break;
}
ob_end_flush();
