<?php
include "../../paths/AbsolutePaths.php";
require_once "../../model/DAO/factory/MySQLDAOFactory.php";
define("GETALL", 1);
define('PERSIST', 2);
define('UPDATE', 3);
define('DELETE', 4);
$factory = new MySQLDAOFactory();
switch ($_GET['option']) {
    case GETALL:
        $lista = $factory->getMarcaDAO()->getList();
        $json = json_encode($lista);
        echo $json;
        break;
    case PERSIST:
        break;
    case UPDATE:
        break;
    case DELETE:
        break;
    default:
        break;
}
