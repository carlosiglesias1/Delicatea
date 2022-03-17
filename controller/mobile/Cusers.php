<?php
require_once "../../model/DAO/UsuarioDAO.php";
define("GETALL", 1);
$factory = new MySQLDAOFactory();
$menu = $_GET['option'];
switch ($menu) {
    case GETALL:
        $lista = $factory->getUsuarioDAO()->getList();
        echo json_encode($lista);
        break;

    default:
        echo json_encode("No encontré nada");
        break;
}
