<?php
ob_start();
$menu = $_GET['menu'];
switch ($menu) {

  case 1:
    require_once("../cabecera.php");
    areUAllowed([3]);
    require_once("../Modelos/Mproductos.php");
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=6&lang=' . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
    }
    //Llamar a la clase subcategorias
    $articulo = new Articulo('articulo');
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    if (isset($_POST['submit']))
      try {
        $idArticulo = $articulo->newArticle() - 1;
        $directorio = $_SESSION['WORKING_PATH'] . "Back/Imagenes/Articulos/$idArticulo";
        $src = $_SESSION['INDEX_PATH'] . "Back/Imagenes/Articulos/$idArticulo";
        require_once($_SESSION['WORKING_PATH'] . "Funciones/uploader.php");
        if ($handler = opendir($directorio)) {
          while (false !== ($file = readdir($handler))) {
            if ($file != "." && $file != "..")
              $articulo->foreignInsert('imagenesArticulos', ["path" => "path", "idArticulo" => "articulo"], ["$src/$file", $idArticulo]);
          }
        }
        closedir($handler);
        header("Location: " . $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=6&lang=" . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
      } catch (PDOException $ex) {
        $location = $_SESSION['INDEX_PATH'] . 'Back/Vistas/Usuario/BVUsuariofail.php?lang=' . $_GET['lang'] . "&ex=" . $ex . "&idTarifa=" . $_GET['idTarifa'];
        echo $location;
        header('Location: ' . $location);
      }

    require_once("../Vistas/Productos/VCrearProd.php");
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
    $articulo = new Articulo('articulo');
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    $id = $_GET['id'];
    $campos = $articulo->getByID($id)->fetch(PDO::FETCH_ASSOC);
    $imagenes = $articulo->getForeignValue('path', 'imagenesArticulos', $id, 'articulo')->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_POST['submit']))
      try {
        $articulo->updateArticle($id);
        header('Location: BCcontrol.php?menu=6&lang=' . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa']);
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    require_once("../Vistas/Productos/VCrearProd.php");
    break;
  default:
    require_once("./BCcontrol.php");
    break;
}
ob_end_flush();
