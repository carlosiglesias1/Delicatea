<?php
$menu = $_GET['menu'];
switch ($menu) {

  case 1:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/MIva.php");
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=7&lang=' . $_GET['lang']);
    }
    //Llamar a la clase Usuarios
    $iva = new IVA();
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    if (isset($_POST['submit']))
      $iva->newUser();
    require_once("../Vistas/IVA/VIva.php");
    break;

  case 2:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/MIva.php");
    $iva = new IVA();
    $id = intval($_GET['id']);
    try {
      $iva->deleteByID($id);
      header('Location: BCcontrol.php?menu=7&lang='.$_SESSION['lang']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../../Funciones/funciones.php");
    require_once("../Modelos/MIva.php");
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
    require_once("../Vistas/IVA/VCrearIVa.php");
    break;

  default:
    require_once("./BCcontrol.php");
    break;
}
