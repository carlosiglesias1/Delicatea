<?php
ob_start();
require_once("../../paths/AbsolutePaths.php");
require_once("../../model/DAO/factory/MySQLDAOFactory.php");
require_once("../../view/back/cabecera.php");
require_once("../Crud.php");
$menu = $_GET['menu'];
$factory = new MySQLDAOFactory();
switch ($menu) {
  case Crud::LOGIN:
    require_once("../../view/back/Login/login.php");
    if (isset($_POST['submit'])) {
      if (isset($_POST["password"])) {
        $password = substr(hash("sha512", $_POST['password']), 0, 50);
      }
      if ($factory->getUsuarioDAO()->logIn(new Usuario(['nick' => $_POST['username'], 'pass' => $password]))) {
        header('Location: BCcontrol.php?menu=3&lang=' . $_GET['lang']);
      }
    }
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
    require_once("../Vistas/Usuario/Vusers.php");
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
    require_once("../Vistas/Marcas/VMarcas.php");
    break;

  case 3:
    $usuario = $factory->getUsuarioDAO();
    $users = $usuario->searchRow($_SESSION['id']);
    $_SESSION['ventanasMenu'] = $usuario->getForeignValue('permisosmenu', 'permiso', $_SESSION['id'], 'usuario', 'permiso');
    require_once("../../Funciones/funciones.php");
    require_once("../../view/back/Login/success.php");
    break;

  case 4:
    require_once("../cabecera.php");
    //Permisos requeridos para acceder al menú
    areUAllowed([4, 5]);
    require_once("../Modelos/DAO/SubcategoriaDAO.php");
    require_once("../Modelos/DAO/CategoriaDAO.php");
    if ($_GET['idCat'] == 0) {
      $subcategoria = new SubCategoriaDAO();
      $subcats = $subcategoria->getList();
    } else {
      $categoriaDAO = new CategoriaDAO();
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
    require_once("../Vistas/Subcategorias/Vsubcategorias.php");
    break;
  case 5:
    require_once("../cabecera.php");
    areUAllowed([4]);
    require_once("../Modelos/DAO/CategoriaDAO.php");
    $categoria = new CategoriaDAO();
    $cats = $categoria->getList();
    $selected = [];
    $j = 0;
    if (isset($_POST['confirmar'])) {
      for ($i = 0; $i < sizeof($cats); $i++) {
        if (isset($_POST[$cats[$i]->getIdCategoria])) {
          $selected[$j] = $cats[$i]['idCategoria'];
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
    require_once("../Vistas/Categorias/Vcategorias.php");
    break;
  case 6:
    require_once("../cabecera.php");
    areUAllowed([3]);
    require_once("../Modelos/Mproductos.php");
    $articulo = new Articulo();
    $prods = $articulo->getAll();
    $selected = [];
    $j = 0;
    if (isset($_POST['confirmar'])) {
      for ($i = 0; $i < sizeof($prods); $i++) {
        if (isset($_POST[$prods[$i]['idArticulo']])) {
          $selected[$j] = $prods[$i]['idArticulo'];
          $j++;
        }
      }
      $selected = serialize($selected);
      $selected = urldecode($selected);
      header("Location: Cprods.php?menu=2&lang=" . $_GET['lang'] . "&selected=" . $selected . "&idTarifa=" . $_GET['idTarifa']);
    }
    if (isset($_POST['Editar'])) {
      for ($i = 0; $i < sizeof($prods); $i++) {
        if (isset($_POST[$prods[$i]['idArticulo']])) {
          $selected[$j] = $prods[$i]['idArticulo'];
          $j++;
        }
      }
      if (sizeof($selected) === 1) {
        header("Location: Cprods.php?menu=3&lang=" . $_GET['lang'] . "&idCat=" . $_GET['idCat'] . "&id=" . $selected[0]);
      } else {
        $_SESSION['error'] = 3;
      }
    }
    require_once("../Vistas/Productos/VProductos.php");
    break;
  case 7:
    require_once("../cabecera.php");
    areUAllowed([10]);
    require_once("../Modelos/MIva.php");
    $tipoIVA = new IVA();
    $tiposIVA = $tipoIVA->getAll();
    $selected = [];
    $j = 0;
    if (isset($_POST['confirmar'])) {
      for ($i = 0; $i < sizeof($tiposIVA); $i++) {
        if (isset($_POST[$tiposIVA[$i]['idIva']])) {
          $selected[$j] = $tiposIVA[$i]['idIva'];
          $j++;
        }
      }
      $selected = serialize($selected);
      $selected = urldecode($selected);
      header("Location: CIva.php?menu=2&lang=" . $_GET['lang'] . "&selected=" . $selected);
    }
    if (isset($_POST['Editar'])) {
      for ($i = 0; $i < sizeof($tiposIVA); $i++) {
        if (isset($_POST[$tiposIVA[$i]['idIva']])) {
          $selected[$j] = $tiposIVA[$i]['idIva'];
          $j++;
        }
      }
      if (sizeof($selected) === 1) {
        header("Location: CIva.php?menu=3&lang=" . $_GET['lang'] . "&idCat=" . $_GET['idCat'] . "&id=" . $selected[0]);
      } else {
        $_SESSION['error'] = 3;
      }
    }
    require_once("../Vistas/IVA/VIva.php");
    break;
  case 8:
    require_once("../cabecera.php");
    areUAllowed([11]);
    require_once("../Modelos/MTarifas.php");
    $tarifa = new Tarifa();
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
    require_once("../Vistas/Tarifas/VTarifas.php");
    break;
  default:
    header("./BCcontrol.php?menu=0&lang=es");
    break;
}
ob_end_flush();