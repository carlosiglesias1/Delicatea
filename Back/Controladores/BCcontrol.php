<?php
//include '../Modelos/Mestandar.php';
$menu = $_GET['menu'];
switch ($menu) {

  case 1:
      require_once("../Modelos/Musers.php");
      require_once("../Vistas/Usuario/Vusers.php");
  break;

  case 2:
    require_once("../modelo/marcas.php");
    require_once("../vista/marcasv.php");
  break;

  /*default:
      header("location:index.php");

  break;*/
}

?>
