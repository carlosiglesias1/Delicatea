<?php
ob_start();
$menu = $_GET['menu'];
switch ($menu) {

  case 1:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/Musers.php");
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=1&lang=' . $_GET['lang']);
    }
    //Llamar a la clase Usuarios
    $usuario = new Usuarios();
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    if (isset($_POST['submit']))
      $usuario->newUser();
    require_once("../Vistas/Usuario/VCreateUser.php");
    break;

  case 2:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/Musers.php");
    $usuario = new Usuarios('usuarios');
    $selected = unserialize($_GET['selected']);
    try {
      foreach ($selected as $fila) {
        $usuario->deleteByID($fila);
      }
      header('Location: BCcontrol.php?menu=1&lang=' . $_SESSION['lang']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/Musers.php");
    $usuario = new Usuarios();
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    $id = intval($_GET['id']);
    $campos = $usuario->getByID($id)->fetch(PDO::FETCH_ASSOC);
    if (isset($_POST['submit']))
      try {
        $usuario->updateUser($id);
        header('Location: BCcontrol.php?menu=1&lang=' . $_GET['lang']);
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    require_once("../Vistas/Usuario/VEditUser.php");
    break;
  case 4:
    require_once("../cabecera.php");
    areUAllowed([1]);
    require_once("../Modelos/Musers.php");
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=1&lang=' . $_GET['lang']);
    }
    $usuario = new Usuarios();
    $id = $_GET['id'];
    $permisos = $usuario->getForeignValue(null, 'permisosmenu', $id, 'usuario')->fetchAll(PDO::FETCH_ASSOC);
    $nombrePermiso = $usuario->getForeignValue(null, 'columnasmenu')->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_POST['submit'])) {
      try {
        foreach ($nombrePermiso as $fila) {
          if (!empty($_POST[$fila['nombre']])) {
            $clave = array_search($fila['idCol'], array_column($permisos, 'permiso'));
            if ($clave === false) {
              $usuario->foreignInsert('permisosmenu', ['usuario', 'permiso'], [$_GET['id'], $fila['idCol']]);
            }
          } else {
            $clave = array_search($fila['idCol'], array_column($permisos, 'permiso'));
            if ($clave !== false) {
              $usuario->foreignDelete('permisosmenu', 'idPermiso', $permisos[$clave]['idPermiso']);
            }
          }
        }
        header("Location: BCcontrol.php?menu=1&lang=es");
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }
    require_once("../Vistas/Permisos/VPermisos.php");
    break;
  default:
    require_once("./BCcontrol.php");
    break;
}
ob_end_flush();
