<?php
ob_start();
$menu = $_GET['menu'];
switch ($menu) {

  case 1:
    require_once("../cabecera.php");
    areUAllowed([1]);
    //require_once("../Modelos/Mcategorias.php");
    require_once("../Modelos/Msubcategorias.php");
    if (isset($_POST['cancelar'])) {
      if ($_GET['idCat'] != 0)
        header('Location: Ccats.php?menu=4&lang=' . $_GET['lang'] . '&idCat=' . $_GET['idCat']);
      else
        header('Location: BCcontrol.php?menu=4&lang=' . $_GET['lang'] . '&idCat=0');
    }
    //Llamar a la clase subcategorias
    $subcategoria = new SubCategoria('subcategoria');
    //Invocamos los datos de la tabla de categorias
    //Si ya pasamos un id de Categoria simplemente buscamos el nombre de ese id
    if ($_GET['idCat'] == 0)
      $categorias = $subcategoria->getForeignValue(null, 'categoria', null, null)->fetchAll(PDO::FETCH_ASSOC);
    else {
      $categorias = $subcategoria->getForeignValue('nombre', 'categoria', $_GET['idCat'], 'idCategoria')->fetchAll(PDO::FETCH_ASSOC);
    }
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    if (isset($_POST['submit']))
      try {
        $subcategoria->newSubCat();
      } catch (PDOException $error) {
        echo $error->getMessage();
      }
    require_once("../Vistas/Subcategorias/VCrearSubCat.php");
    break;

  case 2:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/Msubcategorias.php");
    $subcategoria = new SubCategoria('subcategoria');
    $selected = unserialize($_GET['selected']);
    try {
      foreach ($selected as $fila)
        $subcategoria->deleteByID($fila);
      header("Location: BCcontrol.php?menu=4&lang=" . $_GET['lang'] . "&idCat=" . $_GET['idCat']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../../Funciones/funciones.php");
    require_once("../Modelos/Msubcategorias.php");
    if (isset($_POST['cancelar'])) {
      if ($_GET['idCat'] != 0)
        header('Location: Ccats.php?menu=4&lang=' . $_GET['lang'] . '&idCat=' . $_GET['idCat']);
      else
        header('Location: BCcontrol.php?menu=4&lang=' . $_GET['lang'] . '&idCat=0');
    }
    $subcategoria = new SubCategoria('subcategoria');
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    $id = $_GET['id'];
    $campos = $subcategoria->getByID($id)->fetch(PDO::FETCH_ASSOC);
    $catSubCat = $subcategoria->getForeignValue('nombre', 'categoria', $campos['categoria'], 'idCategoria')->fetchAll(PDO::FETCH_ASSOC);
    $categorias = $subcategoria->getForeignValue(null, 'categoria')->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_POST['submit']))
      try {
        $subcategoria->updateSubcat($id);
        if ($_GET['idCat'] != 0)
          header('Location: Ccats.php?menu=4&lang=' . $_GET['lang'] . '&idCat=' . $_GET['idCat']);
        else
          header('Location: BCcontrol.php?menu=4&lang=' . $_GET['lang'] . '&idCat=0');
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    require_once("../Vistas/Subcategorias/VCrearSubCat.php");
    break;

  default:
    require_once("./BCcontrol.php");
    break;
}
ob_end_flush();
