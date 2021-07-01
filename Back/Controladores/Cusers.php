<?php
//include '../Modelos/Mestandar.php';
$menu = $_GET['menu'];
switch ($menu) {

  case 1:
    require_once("../Modelos/Musers.php");
    //Llamar a la clase Usuarios
    $usuario = new Usuarios('usuarios');
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    if (isset($_POST['submit']))
      $usuario->newUser();
    require_once("../Vistas/Usuario/VCreateUser.php");
    break;

  case 2:
    require_once("../Modelos/Musers.php");
    $usuario = new Usuarios('usuarios');
    $id = intval($_GET['id']);
    $campo = $_GET['campo'];
    echo $id . " " . $campo;
    try {
      $usuario->deleteByID($id);
      header('Location: BCcontrol.php?menu=1');
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    require_once("../Modelos/Musers.php");
    $usuario = new Usuarios('usuarios');
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    $id = intval($_GET['id']);
    $usuario->getByID($id)->fetch(PDO::FETCH_ASSOC);
    print_r($usuario);
    if (isset($_POST['submit']))
      $usuario->newUser();
    require_once("../Vistas/Usuario/VEditUser.php");
    break;

  default:
    header("location:index.php");
    break;
}
