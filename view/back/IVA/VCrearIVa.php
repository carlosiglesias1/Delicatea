<?php
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
?>
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
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=7&lang=" . $_GET['lang'] ?>"><?= $lang['Tabla IVA']['Titulo'] ?></a></li>
                <li><?= $lang['Nuevo IVA']['Boton'] ?></li>
            </ul>
        </div>
        <form method="POST" class="FormNewObject">
            <label for="tipo"><?php echo $lang['Nueva Marca']['Nombre'] ?></label>
            <?php if ($_GET['menu'] == 1) { ?>
                <input type="text" name="tipo">
                <label for="porcentage">Porcentage</label>
                <input type="text" name="porcentage">
            <?php } else {
            ?>
                <input type="text" name="tipo" value="<?= escapar($campos->getTipo()) ?>">
                <label for="porcentage">Porcentage</label>
                <input type="text" name="porcentage" value="<?= escapar($campos->getPorcentage()) ?>">

            <?php } ?>
            <button name="submit" type="submit"><?php if ($_GET['menu'] == 1) {
                                                    echo $lang["Nuevo IVA"]["Registrarse"];
                                                } else {
                                                    echo "Actualizar";
                                                } ?></button>
            <button name="cancelar"><?php echo $lang['Nuevo IVA']['Cancelar'] ?></button>
        </form>
    </div>
</body>

</html>