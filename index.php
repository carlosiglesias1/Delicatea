<?php
include "rutas/webPaths.php";
include "Lenguajes/es.php";
include "Funciones/funciones.php";
echo $lang['conexion'];

?>

<!DOCTYPE html>
<?php
header('Location: Back\Controladores\BCcontrol.php?menu=0&lang=es');
?>