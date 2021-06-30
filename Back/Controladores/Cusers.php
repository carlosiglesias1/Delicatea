<?php
//include '../Modelos/Mestandar.php';
$menu = $_GET['menu'];
switch ($menu) {

  case 1:
      require_once("../Modelos/Musers.php");
      //Llamar a la clase Usuarios
      $usuario = new Usuarios('usuarios');
      // llamamos a la funcion de la clase y almacenamos el return en una variable
      $usuario->newUser();
      require_once("../Vistas/Usuario/VCreateUser.php");
  break;

  case 2:
      require_once("../Modelos/Musers.php");
      $usuario = new Usuarios('usuarios');
      try{
        $usuario->deleteByID($_GET['id']);
      }catch (PDOException $ex){
        echo $ex->getMessage();
      }
      header('Location: Cusers.php?menu=1');
      break;

  /*default:
      header("location:index.php");

  break;*/
}
