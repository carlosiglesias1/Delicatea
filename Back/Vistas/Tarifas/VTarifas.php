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
                <li><?= $lang['Tabla Tarifas']['Titulo'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?= $lang['Tabla Tarifas']['Titulo']; ?></h4>
            <a href="<?= "Ctarifas.php?menu=1&lang=" . $_GET['lang'] ?>" class="New_Button"><?php echo $lang['Nueva Tarifa']['Boton'] ?></a>
            <button class="Borrar" name="Borrar" onclick="cargarModal(2);changeModal()"><i class="icofont-delete-alt"></i> <?= $lang['Tabla Tarifas']['Borrar']; ?></button>
            <button type="submit" class="Editar" name="Editar" form="Tarifas"><i class="icofont-edit-alt"></i> <?= $lang['Tabla Tarifas']['Editar']; ?></button>
        </div>
        <form method="post" id="Tarifas">
            <!--Para que dataTables funcione, debemos tener las mismas columnas en el thead que en tbody-->
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th><label for="selectAll"><?= $lang['seleccionarTodos'] ?></label><input type="checkbox" id="selectAll"></th>
                        <th><?= $lang['Tabla Tarifas']['Nombre'] ?></th>
                        <th><?= $lang['Tabla Tarifas']['Origen'] ?></th>
                        <th><?= $lang['Tabla Tarifas']['Precio Manual'] ?></th>
                        <th><?= $lang['Tabla Tarifas']['Redondeo'] ?></th>
                        <th><?= $lang['Tabla Tarifas']['Ajuste'] ?></th>
                        <th>Ver Productos</th>
                    </tr>
                </thead>
                <tbody>
                    <!--Genero las filas de la tabla dinámicamente, según las filas que encuentre en la base de datos-->
                    <?php
                    if ($tarifas && sizeof($tarifas) > 0) {
                        foreach ($tarifas as $fila) {
                    ?>
                            <tr>
                                <td><input type="checkbox" name="<?= escapar($fila['idTarifa']) ?>" id="<?= escapar($fila['idTarifa']) ?>" class="option"></td>
                                <td><?= escapar($fila["nombre"]); ?></td>
                                <td><?php if (escapar($fila['origen']) != 0) {
                                        if (escapar($fila['origen']) == -1) {
                                            echo "Todas Las Tarifas";
                                        } else {
                                            $nombre = $tarifa->getByID(escapar($fila['origen']))->fetchAll(PDO::FETCH_ASSOC);
                                            echo $nombre[0]['nombre'];
                                        }
                                    } else echo "Coste Producto"; ?></td>
                                <td><?= escapar($fila['precioManual']) ?></td>
                                <td><?= escapar($fila['redondeo']) ?></td>
                                <td><?= escapar($fila['ajuste']) ?></td>
                                <td><a href=<?= "Ctarifas.php?menu=4&idTarifa=" . escapar($fila["idTarifa"]) . "&lang=" . $_GET['lang'] ?>>Ver Productos</a></td>
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
    selectInit();
    dataTableInit();
</script>