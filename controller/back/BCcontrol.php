<?php
ob_start();

require_once("../../paths/AbsolutePaths.php");
require_once("../../model/DAO/factory/MySQLDAOFactory.php");
require_once("../../view/back/cabecera.php");
require_once "../../Funciones/funciones.php";
require_once("../Crud.php");


$menu = $_GET['menu'];
$factory = new MySQLDAOFactory();
switch ($menu) {
  case Crud::LOGIN:
    if (isset($_POST['submit'])) {
      if (isset($_POST["password"])) {
        $password = substr(hash("sha512", $_POST['password']), 0, 50);
      }
      if ($factory->getUsuarioDAO()->logIn(new Usuario(['nick' => $_POST['username'], 'pass' => $password]))) {
        header('Location: BCcontrol.php?menu=3&lang=' . $_GET['lang']);
      }
    }
    require_once("../../view/back/Login/login.php");
    break;
  case 1:
    areUAllowed([1]);
    $usuario = $factory->getUsuarioDAO();
    $users = $usuario->getList();
    $selected = [];
    $j = 0;
    if (isset($_POST['confirmar'])) {
      for ($i = 0; $i < sizeof($users); $i++) {
        if (isset($_POST[$users[$i]->getIdUsr()])) {
          $selected[$j] = $users[$i]->getIdUsr();
          $j++;
        }
      }
      $selected = serialize($selected);
      $selected = urldecode($selected);
      header("Location: Cusers.php?menu=2&lang=" . $_GET['lang'] . "&selected=" . $selected);
    }
    if (isset($_POST['Editar']) && !array_key_exists('error', $_GET)) {
      for ($i = 0; $i < sizeof($users); $i++) {
        if (isset($_POST[$users[$i]->getIdUsr()])) {
          $selected[$j] = $users[$i]->getIdUsr();
          $j++;
        }
      }
      if (sizeof($selected) != 1) {
        $_SESSION['error'] = 3;
      } else {
        header("Location: Cusers.php?menu=3&lang=" . $_GET['lang'] . "&id=" . $selected[0]);
      }
    }
    require_once("../../view/back/Usuario/Vusers.php");
    break;
  case 2:
    areUAllowed([2]);
    $marca = $factory->getMarcaDAO();
    $marcas = $marca->getList();
    $selected = [];
    $j = 0;
    if (isset($_POST['confirmar'])) {
      for ($i = 0; $i < sizeof($marcas); $i++) {
        if (isset($_POST[$marcas[$i]->getIdMarca()])) {
          $selected[$j] = $marcas[$i]->getIdMarca();
          $j++;
        }
      }
      $selected = serialize($selected);
      $selected = urldecode($selected);
      header("Location: Cmarks.php?menu=2&lang=" . $_GET['lang'] . "&selected=" . $selected);
    }
    if (isset($_POST['Editar'])) {
      for ($i = 0; $i < sizeof($marcas); $i++) {
        if (isset($_POST[$marcas[$i]->getIdMarca()])) {
          $selected[$j] = $marcas[$i]->getIdMarca();
          $j++;
        }
      }
      if (!headers_sent()) {
        if (sizeof($selected) === 1) {
          header("Location: Cmarks.php?menu=3&lang=" . $_GET['lang'] . "&id=" . $selected[0]);
        } else {
          $_SESSION['error'] = 3;
        }
      }
    }
    require_once("../../view/back/Marcas/VMarcas.php");
    break;

  case 3:
    $usuario = $factory->getUsuarioDAO();
    $users = $usuario->searchRow($_SESSION['id']);
    $_SESSION['ventanasMenu'] = $usuario->getForeignValue('permisosmenu', 'permiso', $_SESSION['id'], 'usuario', 'permiso');
    require_once("../../view/back/Login/success.php");
    break;

  case 4:
    areUAllowed([4, 5]);
    if ($_GET['idCat'] == 0) {
      $subcategoria = $factory->getSubcategoriaDAO();
      $subcats = $subcategoria->getList();
    } else {
      $categoriaDAO = $factory->getCategoriaDAO();
      $id = $_GET['idCat'];
      $nombreCat = $categoriaDAO->searchRow($id)['nombre'];
      $subcats = $categoriaDAO->getSubcategorias($id);
    }
    $selected = [];
    $j = 0;
    if (isset($_POST['confirmar'])) {
      for ($i = 0; $i < sizeof($subcats); $i++) {
        if (isset($_POST[$subcats[$i]->getIdSubCategoria()])) {
          $selected[$j] = $subcats[$i]->getIdSubCategoria();
          $j++;
        }
      }
      $selected = serialize($selected);
      $selected = urldecode($selected);
      header("Location: Csubcats.php?menu=2&lang=" . $_GET['lang'] . "&selected=" . $selected . "&idCat=" . $_GET['idCat']);
    }
    if (isset($_POST['Editar'])) {
      for ($i = 0; $i < sizeof($subcats); $i++) {
        if (isset($_POST[$subcats[$i]->getIdSubCategoria()])) {
          $selected[$j] = $subcats[$i]->getIdSubCategoria();
          $j++;
        }
      }
      if (sizeof($selected) === 1) {
        header("Location: Csubcats.php?menu=3&lang=" . $_GET['lang'] . "&idCat=" . $_GET['idCat'] . "&id=" . $selected[0]);
      } else {
        $_SESSION['error'] = 3;
      }
    }
    require_once("../../view/back/Subcategorias/Vsubcategorias.php");
    break;
  case 5:
    areUAllowed([4]);
    $categoria = $factory->getCategoriaDAO();
    $cats = $categoria->getList();
    $selected = [];
    $j = 0;
    if (isset($_POST['confirmar'])) {
      for ($i = 0; $i < sizeof($cats); $i++) {
        if (isset($_POST[$cats[$i]->getIdCategoria()])) {
          $selected[$j] = $cats[$i]->getIdCategoria();
          $j++;
        }
      }
      $selected = serialize($selected);
      $selected = urldecode($selected);
      header("Location: Ccats.php?menu=2&lang=" . $_GET['lang'] . "&selected=" . $selected);
    }
    if (isset($_POST['Editar'])) {
      for ($i = 0; $i < sizeof($cats); $i++) {
        if (isset($_POST[$cats[$i]->getIdCategoria()])) {
          $selected[$j] = $cats[$i]->getIdCategoria();
          $j++;
        }
      }
      if (sizeof($selected) === 1) {
        header("Location: Ccats.php?menu=3&lang=" . $_GET['lang'] . "&id=" . $selected[0]);
      } else {
        $_SESSION['error'] = 3;
      }
    }
    require_once("../../view/back/Categorias/Vcategorias.php");
    break;
  case 6:
    areUAllowed([3]);
    $articulo = $factory->getArticuloDAO();
    $prods = $articulo->getList();
    $selected = [];
    $j = 0;
    if (isset($_POST['confirmar'])) {
      for ($i = 0; $i < sizeof($prods); $i++) {
        if (isset($_POST[$prods[$i]->getIdArticulo()])) {
          $selected[$j] = $prods[$i]->getIdArticulo();
          $j++;
        }
      }
      $selected = serialize($selected);
      $selected = urldecode($selected);
      header("Location: Cprods.php?menu=2&lang=" . $_GET['lang'] . "&selected=" . $selected . "&idTarifa=" . $_GET['idTarifa']);
    }
    if (isset($_POST['Editar'])) {
      for ($i = 0; $i < sizeof($prods); $i++) {
        if (isset($_POST[$prods[$i]->getIdArticulo()])) {
          $selected[$j] = $prods[$i]->getIdArticulo();
          $j++;
        }
      }
      if (sizeof($selected) === 1) {
        header("Location: Cprods.php?menu=3&lang=" . $_GET['lang'] . "&idCat=" . $_GET['idCat'] . "&id=" . $selected[0]);
      } else {
        $_SESSION['error'] = 3;
      }
    }
    require_once("../../view/back/Productos/VProductos.php");
    break;
  case 7:
    areUAllowed([10]);
    $tipoIVA = $factory->getIvaDAO();
    $tiposIVA = $tipoIVA->getList();
    $selected = [];
    $j = 0;
    if (isset($_POST['confirmar'])) {
      for ($i = 0; $i < sizeof($tiposIVA); $i++) {
        if (isset($_POST[$tiposIVA[$i]->getIdIva()])) {
          $selected[$j] = $tiposIVA[$i]->getIdIva();
          $j++;
        }
      }
      $selected = serialize($selected);
      $selected = urldecode($selected);
      header("Location: CIva.php?menu=2&lang=" . $_GET['lang'] . "&selected=" . $selected);
    }
    if (isset($_POST['Editar'])) {
      for ($i = 0; $i < sizeof($tiposIVA); $i++) {
        if (isset($_POST[$tiposIVA[$i]->getIdIva()])) {
          $selected[$j] = $tiposIVA[$i]->getIdIva();
          $j++;
        }
      }
      if (sizeof($selected) === 1) {
        header("Location: CIva.php?menu=3&lang=" . $_GET['lang'] . "&idCat=" . $_GET['idCat'] . "&id=" . $selected[0]);
      } else {
        $_SESSION['error'] = 3;
      }
    }
    require_once("../../view/back/IVA/VIva.php");
    break;
  case 8:
    areUAllowed([11]);
    $tarifa = $factory->getTarifaDAO();
    $tarifas = $tarifa->getAll();
    $selected = [];
    $j = 0;
    if (isset($_POST['confirmar'])) {
      for ($i = 0; $i < sizeof($tarifas); $i++) {
        if (isset($_POST[$tarifas[$i]['idTarifa']])) {
          $selected[$j] = $tarifas[$i]['idTarifa'];
          $j++;
        }
      }
      $selected = serialize($selected);
      $selected = urldecode($selected);
      header("Location: Ctarifas.php?menu=2&lang=" . $_GET['lang'] . "&selected=" . $selected);
    }
    if (isset($_POST['Editar'])) {
      for ($i = 0; $i < sizeof($tarifas); $i++) {
        if (isset($_POST[$tarifas[$i]['idTarifa']])) {
          $selected[$j] = $tarifas[$i]['idTarifa'];
          $j++;
        }
      }
      if (sizeof($selected) === 1) {
        header("Location: Ctarifas.php?menu=3&lang=" . $_GET['lang'] . "&idCat=" . $_GET['idCat'] . "&id=" . $selected[0]);
      } else {
        $_SESSION['error'] = 3;
      }
    }
    require_once("../../view/back/Tarifas/VTarifas.php");
    break;
  default:
    header("./BCcontrol.php?menu=0&lang=es");
    break;
}
ob_end_flush();
