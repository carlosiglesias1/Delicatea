<?php
csrf();
if (isset($_POST['mit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
$articulo = new Articulo();
$prods = $articulo->getAll()->fetchAll(PDO::FETCH_ASSOC);
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
                <li><?= $lang['Tabla Articulos']['Titulo'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?= $lang['Tabla Articulos']['Titulo']; ?></h4>
            <a href="<?= "Cprods.php?menu=1&lang=" . $_GET['lang'] ?>" class="New_Button"><?php echo $lang['Nuevo Articulo']['Boton'] ?></a>
        </div>
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th><?= $lang['Tabla Articulos']['ID']; ?></th>
                    <th><?= $lang['Tabla Articulos']['Nombre']; ?></th>
                    <th><?= $lang['Tabla Articulos']['Descripcion']; ?></th>
                    <th><?= $lang['Tabla Articulos']['DescripcionL']; ?></th>
                    <th><?= $lang['Tabla Articulos']['Acciones']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($prods && $articulo->getAll()->rowCount() > 0) {
                    foreach ($prods as $fila) {
                ?>
                        <tr>
                            <td><?php echo escapar($fila["idArticulo"]); ?></td>
                            <td><?php echo escapar($fila["nombre"]); ?></td>
                            <td><?php echo escapar($fila["descripcionCorta"]) ?></td>
                            <td><?php echo escapar($fila["descripcionLarga"]) ?></td>
                            <td class="options">
                                <a href="<?= 'Cprods.php?menu=2&campo=idarticulo&id=' . escapar($fila["idArticulo"]) ?>" onclick="return confirmar('<?php echo $lang['confirmacion']; ?>')" class="Borrar"><i class="icofont-delete-alt"></i> <?= $lang['Tabla Articulos']['Borrar']; ?></a>
                                <a href="<?= 'Cprods.php?menu=3&id=' . escapar($fila["idArticulo"]) . "&lang=" . $_GET['lang'] ?>" class="Editar"><i class="icofont-edit-alt"></i> <?= $lang['Tabla Articulos']['Editar']; ?></a>
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