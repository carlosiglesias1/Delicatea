<?php
include "../../paths/AbsolutePaths.php";
require_once "../../model/DAO/factory/MySQLDAOFactory.php";
define("LOGIN", 0);
define("GETALL", 1);
define('PERSIST', 2);
define('UPDATE', 3);
define('DELETE', 4);
$factory = new MySQLDAOFactory();
