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
        <form method="POST">
            <label for="nickname"><?php echo $lang['Nuevo Usuario']['Nombre'] ?></label>
            <input type="text" name="nickname">
            <label for="password"><?php echo $lang['Nuevo Usuario']['Contraseña'] ?></label>
            <input type="text" name="password">
            <label for="RepPassword"><?php echo $lang['Nuevo Usuario']['Repetir Contraseña'] ?></label>
            <input type="text" name="repPassword">
            <button name="submit" type="submit"><?php if ($_GET['menu'] == 1) {
                                                    echo $lang["Nuevo Usuario"]["Registrarse"];
                                                } else {
                                                    echo "Actualizar";
                                                } ?></button>
            <button name="cancelar"><a href="<?= "BCcontrol.php?menu=1&lang=" . $_GET['lang'] ?>"><?php echo $lang['Nuevo Usuario']['Cancelar'] ?></a></button>
        </form>
    </div>
</body>

</html>
<!--Scripts-->
<script>
    dataTableInit();
</script>