<?php
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
$marca = new Marcas('marca');
$marcas = $marca->getAll()->fetchAll(PDO::FETCH_ASSOC);

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
                <li><?= $lang['Tabla Marcas']['Titulo'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?= $lang['Tabla Marcas']['Titulo']; ?></h4>
            <a href="<?= "Cmarks.php?menu=1&lang=" . $_GET['lang'] ?>" class="New_Button"><?php echo $lang['Nueva Marca']['Boton'] ?></a>
        </div>
        <!--Para que dataTables funcione, debemos tener las mismas columnas en el thead que en tbody-->
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th><?= $lang['Tabla Usuarios']['ID']; ?></th>
                    <th><?= $lang['Tabla Marcas']['Nombre'] ?></th>
                    <th><?= $lang['Tabla Usuarios']['Acciones']; ?></th>
                </tr>
            </thead>
            <tbody>
                <!--Genero las filas de la tabla dinámicamente, según las filas que encuentre en la base de datos-->
                <?php
                if ($marcas && $marca->getAll()->rowCount() > 0) {
                    foreach ($marcas as $fila) {
                ?>
                        <tr>
                            <td><?php echo escapar($fila["idMarca"]); ?></td>
                            <td><?php echo escapar($fila["nombre"]); ?></td>
                            <td class="options">
                                <a href="<?= 'Cmarks.php?menu=2&campo=idMarca&id=' . escapar($fila["idMarca"]) ?>" onclick="return confirmar('<?php echo $lang['confirmacion']; ?>')" class="Borrar"><i class="icofont-delete-alt"></i> <?= $lang['Tabla Marcas']['Borrar']; ?></a>
                                <a href="<?= 'Cmarks.php?menu=3&id=' . escapar($fila["idMarca"]) . "&lang=" . $_GET['lang'] ?>" class="Editar"><i class="icofont-edit-alt"></i> <?= $lang['Tabla Usuarios']['Editar']; ?></a>
                            </td>
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