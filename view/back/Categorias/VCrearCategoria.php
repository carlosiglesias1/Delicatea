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
        <?php require_once $_SESSION['WORKING_PATH'] . "view/back/cabecera.php"; ?>
    </div>
    <div class="sidebar">
        <?php include $_SESSION['WORKING_PATH'] . "view/back/menu.php"; ?>
    </div>
    <div class="contenedor">
        <div class="breadcrumb">
            <ul>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=3&lang=" . $_GET['lang'] ?>"><?= $lang['Inicio'] ?></a></li>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=5&lang=" . $_GET['lang'] ?>"><?= $lang['Tabla Categorias']['Titulo'] ?></a></li>
                <li><?= $lang['Nueva Categoria']['Boton'] ?></li>
            </ul>
        </div>
        <form method="POST" class="FormNewObject">
            <label for="name"><?php echo $lang['Nueva Categoria']['Nombre'] ?></label>
            <?php if ($_GET['menu'] == 1) { ?>
                <input type="text" name="name">
                <label for="name"><?php echo $lang['Nueva Categoria']['Descripcion'] ?></label>
                <input type="text" name="descripcion">
            <?php } else {
            ?>
                <input type="text" name="name" value="<?= escapar($campos->getNombre()) ?>">
                <label for="name"><?php echo $lang['Nueva Categoria']['Descripcion'] ?></label>
                <input type="text" name="descripcion" value="<?= escapar($campos->getDescripcion()) ?>">
            <?php } ?>
            <button name=" submit" type="submit"><?php if ($_GET['menu'] == 1) {
                                                        echo $lang["Nueva Categoria"]["Registrarse"];
                                                    } else {
                                                        echo "Actualizar";
                                                    } ?></button>
            <button name="cancelar"><?php echo $lang['Nuevo Usuario']['Cancelar'] ?></button>
        </form>
    </div>
</body>

</html>