<?php
$menu = $_GET['menu'];
switch ($menu) {
  case 0:
    require_once("../cabecera.php");
    require_once("../Vistas/Login/login.php");
    break;
  case 1:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/Musers.php");
    require_once("../Vistas/Usuario/Vusers.php");
    break;

  case 2:
    require_once("../cabecera.php");
    areUAllowed([1, 2]);
    require_once("../Modelos/Mmarcas.php");
    require_once("../Vistas/Marcas/VMarcas.php");
    break;

  case 3:
    require_once("../cabecera.php");
    require_once("../Modelos/Musers.php");
    require_once("../Vistas/Login/success.php");
    break;

  case 4:
    require_once("../cabecera.php");
    areUAllowed([1, 2]);
    require_once("../Modelos/Msubcategorias.php");
    $subcategoria = new SubCategoria();
    $subcats = $subcategoria->getAll()->fetchAll(PDO::FETCH_ASSOC);
    require_once("../Vistas/Subcategorias/Vsubcategorias.php");
    break;
  case 5:
    require_once("../cabecera.php");
    areUAllowed([1, 2]);
    require_once("../Modelos/Mcategorias.php");
    require_once("../Vistas/Categorias/Vcategorias.php");
    break;
  case 6:
    require_once("../cabecera.php");
    areUAllowed([1, 2]);
    require_once("../Modelos/Mproductos.php");
    require_once("../Vistas/Productos/VProductos.php");
    break;
  default:
    header("./BCcontrol.php?menu=0&lang=es");
    break;
}
