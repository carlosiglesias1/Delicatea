<?php
include "../../paths/AbsolutePaths.php";
require_once "../../model/DAO/factory/MySQLDAOFactory.php";
define("LOGIN", 0);
define("GETALL", 1);
define('PERSIST', 2);
define('UPDATE', 3);
define('DELETE', 4);
$factory = new MySQLDAOFactory();
$menu = $_GET['option'];
switch ($menu) {
    case LOGIN:
        $user = new Usuario();
        $user->setNick($_GET['name']);
        if ($factory->getUsuarioDAO()->logIn($user)) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
        break;
    case GETALL:
        $lista = $factory->getUsuarioDAO()->getList();
        $stringList = array();
        foreach ($lista as $usuario) {
            array_push($stringList, $usuario->toString());
        }
        $json = json_encode($lista);
        echo $json;
        break;
    case PERSIST:
        $usuario = new Usuario(["nick" => $_POST['name'], "pass" => $_POST['pass']]);
        if ($factory->getUsuarioDAO()->addElement(["nickname" => $_POST['name'], "pass" => $_POST['pass']])) {
            echo "success";
        }
        break;
    case UPDATE:
        $factory->getUsuarioDAO()->update(intval($_POST['id']), ["nick"=>$_POST['name'], "rol"=>$_POST['rol']]);
        echo "siiuuu";
        break;
    case DELETE:
        if ($factory->getUsuarioDAO()->delete($_GET['id']) == 1) {
            echo "deleted";
        }
        break;
    default:
        echo json_encode("No encontré nada");
        break;
}
