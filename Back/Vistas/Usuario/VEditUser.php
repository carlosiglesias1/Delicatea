<?php
if ($_SESSION['menu'] != 1) {
    //echo "wrong session";
    //echo 'Location : '.$_SESSION['INDEX_PATH'].'Back/Controladores/BCcontrol.php?menu=0&lang=es';
    header('Location : ' . $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=0&lang=es');
    exit;
}
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
</head>

<body>
    <div class="cabecera">
        <?php require_once $_SESSION['WORKING_PATH'] . "Back/cabecera.php"; ?>
    </div>
    <div class="sidebar">
        <?php include $_SESSION['WORKING_PATH'] . "Back/menu.php"; ?>
    </div>
    <div class="contenedor">
        <form method="POST">
            <label for="nickname"><?php echo $lang['Nuevo Usuario']['Nombre'] ?></label>
            <input type="text" name="nickname" value="<?php echo escapar($campos['nick']) ?>">
            <label for="nickname"><?php echo $lang['Tabla Usuarios']['Rol'] ?></label>
            <input type="text" name="rol" value="<?php echo escapar($campos['rol']) ?>">
            <button name="submit" type="submit"><?php if ($_GET['menu'] == 1) {
                                                    echo $lang["Nuevo Usuario"]["Registrarse"];
                                                } else {
                                                    echo $lang["Nuevo Usuario"]["Actualizar"];
                                                } ?></button>
            <button name="cancelar"><a href="<?= "BCcontrol.php?menu=1&lang=" . $_GET['lang'] ?>"><?php echo $lang['Nuevo Usuario']['Cancelar'] ?></a></button>
        </form>
    </div>
</body>

</html>