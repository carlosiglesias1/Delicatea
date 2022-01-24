<?php
require_once("../../Back/cabecera.php");
switch($_GET['menu']){
    case 0:
        require_once $_SESSION['WORKING_PATH'] . 'Front/Vistas/index.php';
}