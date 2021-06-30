<?php
//include '../Modelos/Mestandar.php';
$menu = $_GET['menu'];
switch ($menu) {

  case 1:
      require_once("../Modelos/Musers.php");
      //Llamar a la clase Usuarios
      //$usuario = new Usuarios('usuarios');
      // llamamos a la funcion de la clase y almacenamos el return en una variable
      //$usuario->newUser();
      require_once("../Vistas/Usuario/Vusers.php");
  break;

  case 2:
    require_once("../modelo/marcas.php");
    //$marca = new Marcasclass();
    $matrizmarca=$marca->vermarcas();
    require_once("../vista/marcasv.php");
  break;

  /*default:
      header("location:index.php");

  break;*/
}

?>
