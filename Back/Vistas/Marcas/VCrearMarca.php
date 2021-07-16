<?php
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="cabecera">
        <?php require_once "../cabecera.php"; ?>
    </div>
    <div class="sidebar">
        <?php include "../menu.php"; ?>
    </div>
    <div class="contenedor">
        <div class="breadcrumb">
            <ul>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=3&lang=" . $_GET['lang'] ?>"><?= $lang['Inicio'] ?></a></li>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=2&lang=" . $_GET['lang'] ?>"><?= $lang['Tabla Marcas']['Titulo'] ?></a></li>
                <li><?= $lang['Nueva Marca']['Boton'] ?></li>
            </ul>
        </div>
        <form method="POST" class="FormNewObject">
            <label for="name"><?php echo $lang['Nueva Marca']['Nombre'] ?></label>
            <?php if ($_GET['menu'] == 1) { ?>
                <input type="text" name="name">
            <?php } else {
            ?>
                <input type="text" name="name" value="<?= escapar($campos['nombre']) ?>">
            <?php } ?>
            <button name="submit" type="submit"><?php if ($_GET['menu'] == 1) {
                                                    echo $lang["Nueva Marca"]["Registrarse"];
                                                } else {
                                                    echo "Actualizar";
                                                } ?></button>
            <button name="cancelar"><?php echo $lang['Nuevo Usuario']['Cancelar'] ?></button>
        </form>
    </div>
</body>

</html>
<!--Scripts-->
<script>
    dataTableInit();
</script>