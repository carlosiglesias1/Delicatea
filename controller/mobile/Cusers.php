<?php
include "../../paths/AbsolutePaths.php";
require_once "../../model/DAO/factory/MySQLDAOFactory.php";
require_once "../Crud.php";
$factory = new MySQLDAOFactory();
$menu = $_GET['option'];
switch ($menu) {
    case Crud::LOGIN:
        $user = $factory->getUsuarioDAO()->get();
        $user->setNick('admin');
        $user->setPass('c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3');
        if ($factory->getUsuarioDAO()->mobileLogIn($user)) {
            $user = $factory->getUsuarioDAO()->searchByName($user->getNick());
            echo json_encode($factory->getUsuarioDAO()->getPermissions($_SESSION['id']));
        } else {
            echo json_encode([0]);
        }
        break;
    case Crud::GETALL:
        $lista = $factory->getUsuarioDAO()->getList();
        $json = json_encode($lista);
        echo $json;
        break;
    case Crud::PERSIST:
        if ($factory->getUsuarioDAO()->addElement(["nick" => $_POST['name'], "pass" => substr(hash("sha512", $_POST['pass']), 0, 50)])) {
            echo "success";
        }
        break;
    case Crud::UPDATE:
        $factory->getUsuarioDAO()->update(intval($_POST['id']), ["nick" => $_POST['name'], "rol" => $_POST['rol']]);
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
