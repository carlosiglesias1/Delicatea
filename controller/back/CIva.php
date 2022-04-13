<?php
ob_start();

require_once("../../Funciones/funciones.php");
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
    if (isset($_POST['submit'])) {
      $valores = [
        "tipo" => $_POST["tipo"],
        "porcentage" => $_POST["porcentage"]
      ];
      $iva->addElement($valores);
      header("Location: BCcontrol.php?menu=7&lang=es");
    }
    require_once("../../view/back/IVA/VCrearIva.php");
    break;

  case 2:
    areUAllowed([1]);
    $iva = $factory->getIvaDAO();
    $selected = unserialize($_GET['selected']);
    try {
      foreach ($selected as $fila) {
        $iva->delete($fila);
      }
      header('Location: BCcontrol.php?menu=7&lang=' . $_SESSION['lang']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    areUAllowed([1]);
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=7&lang=' . $_GET['lang']);
    }
    $iva = $factory->getIvaDAO();
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    $id = $_GET['id'];
    $campos = $iva->searchRow($id);
    if (isset($_POST['submit'])) {
      try {
        $valores = [
          "tipo" => $_POST['tipo'],
          "porcentage" => $_POST['porcentage']
        ];
        $iva->update($id, $valores);
        header('Location: BCcontrol.php?menu=7&lang=' . $_GET['lang']);
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }
    require_once("../../view/back/IVA/VCrearIva.php");
    break;

  default:
    require_once("./BCcontrol.php");
    break;
}
ob_end_flush();
