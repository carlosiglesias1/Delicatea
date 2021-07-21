<?php
csrf();
if (isset($_POST['mit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
$categoria = new Categorias();
$cats = $categoria->getAll()->fetchAll(PDO::FETCH_ASSOC);
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
                <li><?= $lang['Tabla Categorias']['Titulo'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?= $lang['Tabla Categorias']['Titulo']; ?></h4>
            <a href="<?= "Ccats.php?menu=1&lang=" . $_GET['lang'] ?>" class="New_Button"><?php echo $lang['Nueva Categoria']['Boton'] ?></a>
        </div>
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th><?= $lang['Tabla Categorias']['ID']; ?></th>
                    <th><?= $lang['Tabla Categorias']['Nombre']; ?></th>
                    <th><?= $lang['Tabla Categorias']['Descripcion']; ?></th>
                    <th>Ver Subcategorias</th>
                    <th><?= $lang['Tabla Categorias']['Acciones']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($cats && $categoria->getAll()->rowCount() > 0) {
                    foreach ($cats as $fila) {
                ?>
                        <tr>
                            <td><?php echo escapar($fila["idCategoria"]); ?></td>
                            <td><?php echo escapar($fila["nombre"]); ?></td>
                            <td><?php echo escapar($fila["descripcion"]) ?></td>
                            <td><a href="<?= 'Ccats.php?menu=4&idCat=' . escapar($fila["idCategoria"]) . "&lang=" . $_GET['lang']  ?>" class="Special"><i class="icofont-list"></i> Ver</a></td>
                            <td class="options">
                                <a href="<?= 'Ccats.php?menu=2&campo=idCategoria&id=' . escapar($fila["idCategoria"]) ?>" onclick="return confirmar('<?php echo $lang['confirmacion']; ?>')" class="Borrar"><i class="icofont-delete-alt"></i> <?= $lang['Tabla Categorias']['Borrar']; ?></a>
                                <a href="<?= 'Ccats.php?menu=3&id=' . escapar($fila["idCategoria"]) . "&lang=" . $_GET['lang'] ?>" class="Editar"><i class="icofont-edit-alt"></i> <?= $lang['Tabla Categorias']['Editar']; ?></a>
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