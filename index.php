<?php
include "Lenguajes/es.php";
echo $lang['conexion'];

?>

<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Location: controller/back/BCcontrol.php?menu=0&lang=es');
?>