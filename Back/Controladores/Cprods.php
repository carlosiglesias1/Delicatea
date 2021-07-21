<?php
$menu = $_GET['menu'];
switch ($menu) {

  case 1:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/Mproductos.php");
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=6&lang=' . $_GET['lang']);
    }
    //Llamar a la clase subcategorias
    $articulo = new Articulo('articulo');
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    if (isset($_POST['submit']))
      $articulo->newArticle();
    require_once("../Vistas/Productos/VCrearProd.php");
    break;

  case 2:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/Mproductos.php");
    $articulo = new Articulo('articulo');
    $id = intval($_GET['id']);
    try {
      $articulo->deleteByID($id);
      header('Location: BCcontrol.php?menu=6&lang='.$_SESSION['lang']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../../Funciones/funciones.php");
    require_once("../Modelos/Mproductos.php");
    if (isset($_POST['cancelar'])) {
        header('Location: BCcontrol.php?menu=6&lang=' . $_GET['lang']);
      }
    $articulo = new Articulo('articulo');
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    $id = $_GET['id'];
    $campos = $articulo->getByID($id)->fetch(PDO::FETCH_ASSOC);
    if (isset($_POST['submit']))
      try {
        $articulo->updateArticle($id);
        header('Location: BCcontrol.php?menu=6&lang=' . $_GET['lang']);
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    require_once("../Vistas/Productos/VCrearProd.php");
    break;

  default:
    require_once("./BCcontrol.php");
    break;
}
