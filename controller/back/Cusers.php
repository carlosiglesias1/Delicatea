<?php
ob_start();
require_once("../../paths/AbsolutePaths.php");
require_once("../../model/DAO/factory/MySQLDAOFactory.php");
require_once("../../Funciones/funciones.php");
require_once("../../view/back/cabecera.php");
$menu = $_GET['menu'];
$factory = new MySQLDAOFactory();
switch ($menu) {
  case 1:
    areUAllowed([1]);
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=1&lang=' . $_GET['lang']);
    }
    //Llamar a la clase Usuarios
    $usuario = $factory->getUsuarioDAO();
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    if (isset($_POST['submit'])) {
      $valores = [
        "nick" => $_POST['nick'],
        "pass" => substr(hash("sha512", $_POST['password']), 0, 50)
      ];
      $usuario->addElement($valores);
      header('Location: ' . $_SESSION['INDEX_PATH'] . 'controller/back/BCcontrol.php?menu=1&lang=' . $_GET['lang']);
    }
    require_once("../../view/back/Usuario/VCreateUser.php");
    break;

  case 2:
    areUAllowed([1]);
    $usuario = $factory->getUsuarioDAO();
    $selected = unserialize($_GET['selected']);
    try {
      foreach ($selected as $fila) {
        $usuario->delete($fila);
      }
      header('Location: BCcontrol.php?menu=1&lang=' . $_SESSION['lang']);
    } catch (PDOException $ex) {
      echo $ex->getMessage();
    }
    break;

  case 3:
    areUAllowed([1]);
    $usuario = $factory->getUsuarioDAO();
    //Llamamos a la funcion de la clase y almacenamos el return en una variable
    $id = intval($_GET['id']);
    $campos = $usuario->searchRow($id);
    if (isset($_POST['submit'])) {
      try {
        $valores = [
          "nick" => $_POST['nickname'],
          "rol" => $_POST['rol']
        ];
        $usuario->update($id, $valores);
        header('Location: BCcontrol.php?menu=1&lang=' . $_GET['lang']);
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }
    require_once("../../view/back/Usuario/VEditUser.php");
    break;
  case 4:
    areUAllowed([1]);
    require_once "../../model/Classes/Permiso.php";
    if (isset($_POST['cancelar'])) {
      header('Location: BCcontrol.php?menu=1&lang=' . $_GET['lang']);
    }
    $usuario = $factory->getUsuarioDAO();
    $id = $_GET['id'];
    $permisos = $usuario->getPermissions($id);
    $nombrePermiso = $usuario->getForeignValue('columnasmenu');
    print_r($permisos);
    echo "<br>";
    print_r(array_column($permisos, 'permiso'));
    if (isset($_POST['submit'])) {
      try {
        foreach ($nombrePermiso as $fila) {
          if (isset($_POST[$fila['nombre']])) {
            $clave = in_array($fila['idCol'], array_column($permisos, 'permiso'), true);
            if ($clave !== false) {
              $usuario->foreignInsert('permisosmenu', ['usuario', 'permiso'], [$_GET['id'], $fila['idCol']]);
            }
          } else {
            $clave = in_array($fila['idCol'], array_column($permisos, 'permiso'), true);
            if ($clave !== true) {
              $usuario->foreignDelete('permisosmenu', 'idPermiso', $permisos[$clave]['idPermiso']);
            }
          }
        }
        header("Location: BCcontrol.php?menu=1&lang=es");
      } catch (PDOException $ex) {
        echo $ex->getMessage();
      }
    }
    require_once("../../view/back/Permisos/VPermisos.php");
    break;
  default:
    require_once("./BCcontrol.php");
    break;
}
ob_end_flush();
