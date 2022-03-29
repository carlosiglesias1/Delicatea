<?php
include "../../paths/AbsolutePaths.php";
require_once "../../model/DAO/factory/MySQLDAOFactory.php";
require_once "../Crud.php";
$factory = new MySQLDAOFactory();
switch ($_GET['option']) {
    case Crud::GETALL:
        $lista = $factory->getMarcaDAO()->getList();
        $json = json_encode($lista);
        echo $json;
        break;
    case Crud::PERSIST:
        $factory->getMarcaDAO()->addElement(['name' => $_POST['name']]);
        break;
    case Crud::UPDATE:
        $factory->getMarcaDAO()->update(intval($_POST['id']), ["nombre" => $_POST['nombre']]);
        break;
    case Crud::DELETE:
        $factory->getMarcaDAO()->delete($_GET['id']);
        break;
    default:
        break;
}
