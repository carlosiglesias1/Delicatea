<?php
//Base Modelos
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

/**DEFINICIONES */

$_SESSION['WORKING_PATH'] = "C:/Users/usuario/Documents/www/Delicatea/";
$_SESSION['INDEX_PATH'] = "http://localhost/Delicatea/";

require_once $_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php';
require_once $_SESSION['WORKING_PATH'] . 'Funciones/funciones.php';
require_once $_SESSION['WORKING_PATH'] . 'Lenguajes/config.php';
//echo $_SESSION['ruta'] . "<br>";
//$ph = $_SESSION['rRuta'];
//echo 'href=' . $_SESSION['rRuta'] . "/icofont/icofont.min.css<br>";
?>
<!DOCTYPE html>

<head>
    <title>Delicatea</title>
    <link rel="stylesheet" href="<?php echo  $_SESSION['INDEX_PATH'] . "icofont/icofont.min.css"; ?>">
    <link rel="stylesheet" href="<?php echo  $_SESSION['INDEX_PATH'] . 'Back/Estilos/MenuPrincipal.css'; ?>">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<div class="cabecera">
    <a href="<?= "http://" . $_SERVER['HTTP_HOST'] . str_replace("lang=" . $_GET['lang'], "lang=es", $_SERVER['REQUEST_URI']) ?>"><?php echo $lang['es'] ?></a>
    <a href="<?= "http://" . $_SERVER['HTTP_HOST'] . str_replace("lang=" . $_GET['lang'], "lang=en", $_SERVER['REQUEST_URI']) ?>"><?php echo $lang['en'] ?></a>
    <a href="<?= "http://" . $_SERVER['HTTP_HOST'] . str_replace("lang=" . $_GET['lang'], "lang=gl", $_SERVER['REQUEST_URI']) ?>"><?php echo $lang['gl'] ?></a>
</div>