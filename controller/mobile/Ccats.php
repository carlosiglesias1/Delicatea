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
    $lista = $factory->getCategoriaDAO()->getAll();
    $lista = json_encode($lista);
    echo $lista;
    break;
  case Crud::PERSIST:
    $factory->getCategoriaDAO()->addElement(["nombre" => $_POST['nombre'], "descripcion" => $_POST['descripcion'], "categoria" => $_POST['categoria']]);
    break;
  case Crud::UPDATE:
    $factory->getCategoriaDAO()->update(intval($_POST['id']), ["nombre" => $_POST['nombre'], "descripcion" => $_POST['descripcion'], "categoria" => $_POST['categoria']]);
    break;
  case Crud::DELETE:
    $factory->getCategoriaDAO()->delete($_POST['id']);
    break;
  default:
    break;
}
