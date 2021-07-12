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
    require_once("../Modelos/Musers.php");
    require_once("../Vistas/Producto/VProductos.php");
    break;

  case 3:
    require_once("../cabecera.php");
    require_once("../Modelos/Musers.php");
    require_once("../Vistas/Login/success.php");
    echo $_SESSION['menu'];
    break;

  default:
    header("./BCcontrol.php?menu=0&lang=es");
    break;
}
