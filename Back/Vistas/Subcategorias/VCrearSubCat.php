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
                <?php if ($_GET['idCat'] != 0) { ?>
                    <li><a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=5&lang=" . $_GET['lang'] ?>"><?= $lang['Tabla Categorias']['Titulo'] ?></a></li>
                <?php } ?>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=4&lang=" . $_GET['lang'] . "&idCat=0" ?>"><?= $lang['Tabla Subcategorias']['Titulo'] ?></a></li>
                <li><?= $lang['Nueva Subcategoria']['Boton'] ?></li>
            </ul>
        </div>
        <form method="POST" class="FormNewObject">
            <label for="name"><?php echo $lang['Nueva Subcategoria']['Nombre'] ?></label>
            <?php if ($_GET['menu'] == 1) { ?>
                <input type="text" name="name">
                <label for="name"><?php echo $lang['Nueva Subcategoria']['Descripcion'] ?></label>
                <input type="text" name="descripcion">
                <label for="categoria"><?php echo $lang['Nueva Subcategoria']['Categoria'] ?></label>
                <?php if ($_GET['idCat'] > 0) { ?>
                    <label for="categoria"><?= $categorias[0]['nombre'] ?></label>
                    <input type="hidden" name="categoria" value="<?= $_GET['idCat'] ?>">
                <?php } else { ?>
                    <select name="categoria">
                        <?php
                        foreach ($categorias as $fila) {
                        ?>
                            <option value="<?= $fila['idCategoria'] ?>"><?= $fila['nombre'] ?></option>
                        <?php
                        } ?>
                    </select>
                <?php } ?>
            <?php } else {
            ?>
                <input type="text" name="name" value="<?= escapar($campos->getNombre()) ?>">
                <label for="name"><?php echo $lang['Nueva Subcategoria']['Descripcion'] ?></label>
                <input type="text" name="descripcion" value="<?= escapar($campos->getDescripcion()) ?>">
                <label for="categoria"><?php echo $lang['Nueva Subcategoria']['Categoria'] ?></label>
                <select name="categoria">
                    <option selected value="<?= $campos->getCategoria() ?>"><?= $catSubCat[0]['nombre'] ?></option>
                    <?php
                    foreach ($categorias as $fila) {
                        if ($fila['nombre'] != $catSubCat[0]['nombre']) {
                    ?>
                            <option value="<?= $fila['idCategoria'] ?>"><?= $fila['nombre'] ?></option>
                    <?php
                        }
                    } ?>
                </select>
            <?php } ?>
            <button name=" submit" type="submit"><?php if ($_GET['menu'] == 1) {
                                                        echo $lang["Nueva Subcategoria"]["Registrarse"];
                                                    } else {
                                                        echo "Actualizar";
                                                    } ?></button>
            <button name="cancelar"><?php echo $lang['Nuevo Usuario']['Cancelar'] ?></button>
        </form>
    </div>
</body>

</html>