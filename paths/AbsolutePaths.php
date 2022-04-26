<?php
//Base Modelos
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
$_SESSION['WORKING_PATH'] = 'C:/xampp/htdocs/Delicatea/';
$_SESSION['INDEX_PATH'] = 'http://localhost:444/Delicatea/';
