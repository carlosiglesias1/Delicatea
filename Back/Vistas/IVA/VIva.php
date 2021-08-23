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
                <li><?= $lang['Tabla IVA']['Titulo'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?= $lang['Tabla IVA']['Titulo']; ?></h4>
            <a href="<?= "CIva.php?menu=1&lang=" . $_GET['lang'] ?>" class="New_Button"><?php echo $lang['Nuevo IVA']['Boton'] ?></a>
            <button class="Borrar" name="Borrar" onclick="cargarModal(2); changeModal()"><i class="icofont-delete-alt"></i> <?= $lang['Tabla IVA']['Borrar']; ?></button>
            <button class="Editar" name="Editar" form="Iva"><i class="icofont-edit-alt"></i> <?= $lang['Tabla IVA']['Editar']; ?></button>

        </div>
        <form method="post" id="Iva">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th> <label for="selectAll"><?= $lang['seleccionarTodos'] ?></label><input type="checkbox" id="selectAll"></th>
                        <th><?= $lang['Tabla IVA']['Tipo']; ?></th>
                        <th><?= $lang['Tabla IVA']['Porcentage']; ?></th>
                        <th><?= $lang['Tabla IVA']['Recargo'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($tiposIVA && $tipoIVA->getAll()->rowCount() > 0) {
                        foreach ($tiposIVA as $fila) {
                    ?>
                            <tr>
                                <td><input type="checkbox" name="<?= escapar($fila["idIva"]); ?>" id="<?= escapar($fila["idIva"]); ?>"></td>
                                <td><label for="<?= escapar($fila["idIva"]); ?>"><?php echo escapar($fila["tipo"]); ?></label></td>
                                <td><label for="<?= escapar($fila["idIva"]); ?>"><?php echo escapar($fila["porcentage"]) ?></label></td>
                                <td><label for="<?= escapar($fila["idIva"]); ?>"><?= escapar($fila["recargoEquivalencia"]) ?></label></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                <tbody>
            </table>
            <?php
            if (isset($_SESSION['error'])) {
            ?> <div class="modal abrir" id="modal">
                    <script>
                        cargarModal(<?= $_SESSION['error'] ?>)
                    </script>
                </div> <?php
                    } else { ?>
                <div class="modal" id="modal">
                </div><?php
                    }
                    unset($_SESSION['error']);  ?>
        </form>
    </div>
</body>

</html>
<!--Scripts-->
<script>
    dataTableInit();
</script>