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
</head>

<body>
    <div class="cabecera">
        <?php require_once $_SESSION['WORKING_PATH'] . "Back/cabecera.php"; ?>
    </div>
    <div class="sidebar">
        <?php include $_SESSION['WORKING_PATH'] . "Back/menu.php"; ?>
    </div>
    <div class="contenedor">
        <div class="breadcrumb">
            <ul>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=3&lang=" . $_GET['lang'] ?>"><?= $lang['Inicio'] ?></a></li>
                <?php
                if ($_GET['idCat'] != 0) {
                ?>
                    <li><a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=5&lang=" . $_GET['lang'] ?>"><?= $lang['Tabla Categorias']['Titulo'] ?></a></li>
                <?php
                } ?>
                <li><?= $lang['Tabla Subcategorias']['Titulo'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?= $lang['Tabla Subcategorias']['Titulo']; ?></h4>
            <a href="<?= "Csubcats.php?menu=1&lang=" . $_GET['lang'] . '&idCat=' . $_GET['idCat'] ?>" class="New_Button"><?php echo $lang['Nueva Subcategoria']['Boton'] ?></a>
            <?php if ($_GET['idCat'] != 0) { ?>
                <button><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=5&lang=' . $_GET['lang'] ?>"><?= $lang['Nueva Subcategoria']['Cancelar'] ?></a></button>
            <?php } ?>
        </div>
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th><?= $lang['Tabla Subcategorias']['ID']; ?></th>
                    <th><?= $lang['Tabla Subcategorias']['Nombre']; ?></th>
                    <th><?= $lang['Tabla Subcategorias']['Descripcion']; ?></th>
                    <th><?= $lang['Tabla Subcategorias']['Acciones']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($subcats && sizeof($subcats) > 0) {
                    foreach ($subcats as $fila) {
                ?>
                        <tr>
                            <td><?php echo escapar($fila["idSubCategoria"]); ?></td>
                            <td><?php echo escapar($fila["nombre"]); ?></td>
                            <td><?php echo escapar($fila["descripcion"]) ?></td>
                            <?php if ($_GET['idCat'] != 0) { ?>
                                <td class="options">
                                    <a href="<?= 'Csubcats.php?menu=2&campo=idSubcategoria&id=' . escapar($fila["idSubCategoria"]) ?>" onclick="return confirmar('<?php echo $lang['confirmacion']; ?>')" class="Borrar"><i class="icofont-delete-alt"></i> <?= $lang['Tabla Subcategorias']['Borrar']; ?></a>
                                    <a href="<?= 'Csubcats.php?menu=3&id=' . escapar($fila["idSubCategoria"]) . "&lang=" . $_GET['lang'] . '&idCat=' . $_GET['idCat'] ?>" class="Editar"><i class="icofont-edit-alt"></i> <?= $lang['Tabla Subcategorias']['Editar']; ?></a>
                                </td>
                            <?php } else { ?>
                                <td class="options">
                                    <a href="<?= 'Csubcats.php?menu=2&campo=idSubcategoria&id=' . escapar($fila["idSubCategoria"]) ?>" onclick="return confirmar('<?php echo $lang['confirmacion']; ?>')" class="Borrar"><i class="icofont-delete-alt"></i> <?= $lang['Tabla Subcategorias']['Borrar']; ?></a>
                                    <a href="<?= 'Csubcats.php?menu=3&id=' . escapar($fila["idSubCategoria"]) . "&lang=" . $_GET['lang'] . '&idCat=0' ?>" class="Editar"><i class="icofont-edit-alt"></i> <?= $lang['Tabla Subcategorias']['Editar']; ?></a>
                                </td>
                            <?php } ?>
                        </tr>
                <?php
                    }
                }
                ?>
            <tbody>
        </table>
    </div>
</body>

</html>
<!--Scripts-->
<script>
    dataTableInit();
</script>