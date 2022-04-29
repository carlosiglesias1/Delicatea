<?PHP
require_once("../../../paths/AbsolutePaths.php");
require_once($_SESSION['WORKING_PATH'] . "view/back/cabecera.php");
require_once($_SESSION['WORKING_PATH'] . "Funciones/funciones.php");

csrf();
if (
  isset($_POST['submit']) &&
  !hash_equals($_SESSION['csrf'], $_POST['csrf'])
) {
  die();
}
?>
<!DOCTYPE html>
<p>NO ME VALE TONTO<?= $_GET['ex'] ?></p>
<button><a href="../../Controladores/BCcontrol.php?menu=1&lang=es">Por Bobo</a></button>