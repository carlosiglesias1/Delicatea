<?php
include "../../paths/AbsolutePaths.php";
require_once "../../model/DAO/factory/MySQLDAOFactory.php";
require_once "../Crud.php";
$factory = new MySQLDAOFactory();
$menu = $_GET['option'];
switch ($menu) {
    case Crud::LOGIN:
        $user = new Usuario();
        $user->setNick($_GET['name']);
        if ($factory->getUsuarioDAO()->logIn($user)) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
        break;
    case Crud::GETALL:
        $lista = $factory->getUsuarioDAO()->getList();
        $json = json_encode($lista);
        echo $json;
        break;
    case Crud::PERSIST:
        //$usuario = new Usuario(["nick" => $_POST['name'], "pass" => $_POST['pass']]);
        if ($factory->getUsuarioDAO()->addElement(["nick" => $_POST['name'], "pass" => substr(hash("sha512", $_POST['pass']), 0, 50)])) {
            echo "success";
        }
        break;
    case Crud::UPDATE:
        $factory->getUsuarioDAO()->update(intval($_POST['id']), ["nick"=>$_POST['name'], "rol"=>$_POST['rol']]);
        echo "siiuuu";
        break;
    case Crud::DELETE:
        if ($factory->getUsuarioDAO()->delete($_GET['id']) == 1) {
            echo "deleted";
        }
        break;
    default:
        echo json_encode("No encontré nada");
        break;
}
