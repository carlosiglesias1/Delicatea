<?php
ob_start();
require_once("../../view/back/cabecera.php");
require_once("../../Funciones/funciones.php");
require_once("../../model/DAO/factory/MySQLDAOFactory.php");
$menu = $_GET['menu'];
$factory = new MySQLDAOFactory();
switch ($menu) {
  case 1:
    areUAllowed([1]);
    if (isset($_POST['cancelar'])) {
      if ($_GET['idCat'] != 0) {
        header('Location: Ccats.php?menu=4&lang=' . $_GET['lang'] . '&idCat=' . $_GET['idCat']);
      } else {
        header('Location: BCcontrol.php?menu=4&lang=' . $_GET['lang'] . '&idCat=0');
      }
    }
    $subcategoria = $factory->getSubcategoriaDAO();
    //Invocamos los datos de la tabla de categorias
    //Si ya pasamos un id de Categoria simplemente buscamos el nombre de ese id
    if ($_GET['idCat'] == 0) {
      $categorias = $subcategoria->getForeignValue('categoria', null, null);
    } else {
      $categorias = $subcategoria->getForeignValue('categoria', 'nombre', $_GET['idCat'], 'idCategoria');
    }
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    if (isset($_POST['submit'])) {
      try {
        $valores = [
          $_POST['name'],
          $_POST['descripcion'],
          $_POST['categoria']
        ];
        $subcategoria->addElement($valores);
      } catch (PDOException $error) {
        echo $error->getMessage();
      }
    }
    require_once("../Vistas/Subcategorias/VCrearSubCat.php");
    break;

  case 2:
    areUAllowed([1]);
    $subcategoria = $factory->getSubcategoriaDAO();
    $selected = unserialize($_GET['selected']);
    try {
      foreach ($selected as $fila) {
        $subcategoria->delete($fila);
      }
      header("Location: BCcontrol.php?menu=4&lang=" . $_GET['lang'] . "&idCat=" . $_GET['idCat']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    areUAllowed([5]);
    if (isset($_POST['cancelar'])) {
      if ($_GET['idCat'] != 0) {
        header('Location: Ccats.php?menu=4&lang=' . $_GET['lang'] . '&idCat=' . $_GET['idCat']);
      } else {
        header('Location: BCcontrol.php?menu=4&lang=' . $_GET['lang'] . '&idCat=0');
      }
    }
    $subcategoria = $factory->getSubcategoriaDAO();
    $id = $_GET['id'];
    $campos = $subcategoria->searchRow($id);
    $catSubCat = $subcategoria->getForeignValue('categoria', 'nombre', $campos->getCategoria(), 'idCategoria');
    $categorias = $subcategoria->getForeignValue('categoria');
    if (isset($_POST['submit'])) {
      try {
        $valores = [
          $_POST['name'],
          $_POST['descripcion'],
          $_POST['categoria']
        ];
        $subcategoria->update($id, $valores);
        if ($_GET['idCat'] != 0) {
          header('Location: Ccats.php?menu=4&lang=' . $_GET['lang'] . '&idCat=' . $_GET['idCat']);
        } else {
          header('Location: BCcontrol.php?menu=4&lang=' . $_GET['lang'] . '&idCat=0');
        }
      } catch (PDOException $ex) {
        error_log($ex->getMessage());
      }
    }
    require_once("../Vistas/Subcategorias/VCrearSubCat.php");
    break;

  default:
    require_once("./BCcontrol.php");
    break;
}
ob_end_flush();
