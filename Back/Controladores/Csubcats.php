<?php
$menu = $_GET['menu'];
switch ($menu) {

  case 1:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/Msubcategorias.php");
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=4&lang=' . $_GET['lang']);
    }
    //Llamar a la clase subcategorias
    $subcategoria = new SubCategoria('subcategoria');
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    if (isset($_POST['submit']))
      $subcategoria->newSubCat();
    require_once("../Vistas/subcategoria/VCreateUser.php");
    break;

  case 2:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/Msubcategorias.php");
    $subcategoria = new SubCategoria('subcategoria');
    $id = intval($_GET['id']);
    try {
      $subcategoria->deleteByID($id);
      header('Location: BCcontrol.php?menu=4&lang='.$_SESSION['lang']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../../Funciones/funciones.php");
    require_once("../Modelos/Msubcategorias.php");
    $subcategoria = new SubCategoria('subcategoria');
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    $id = $_GET['id'];
    $campos = $subcategoria->getByID($id)->fetch(PDO::FETCH_ASSOC);
    if (isset($_POST['submit']))
      try {
        $subcategoria->updateUser($id);
        header('Location: BCcontrol.php?menu=4&lang=' . $_GET['lang']);
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    require_once("../Vistas/subcategoria/VEditUser.php");
    break;

  default:
    require_once("./BCcontrol.php");
    break;
}
