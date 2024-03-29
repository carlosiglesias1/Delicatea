<?php
ob_start();

require_once("../../paths/AbsolutePaths.php");
require_once("../../view/back/cabecera.php");
require_once "../../Funciones/funciones.php";
require_once("../../model/DAO/factory/MySQLDAOFactory.php");

$menu = $_GET['menu'];
$factory = new MySQLDAOFactory();

switch ($menu) {
  case Crud::GETALL:
    $lista = $factory->getArticuloDAO()->getAll();
    $lista = json_encode($lista);
    echo $lista;
    break;
  case Crud::PERSIST:
    $factory->getArticuloDAO()->addElement(["tipo" => $_POST['tipo'], "porcentaje" => floatval($_POST['porcentaje'])]);
    break;
  case Crud::UPDATE:
    $factory->getArticuloDAO()->update(intval($_POST['id']), ["tipo" => $_POST['tipo'], "porcentaje" => floatval($_POST['porcentaje'])]);
    break;
  case Crud::DELETE:
    $factory->getArticuloDAO()->delete($_POST['id']);
    break;
  default:
    break;
}