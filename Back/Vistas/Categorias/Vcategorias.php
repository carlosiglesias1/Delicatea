<?php
csrf();
if (isset($_POST['mit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
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
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=3&lang=" . $_GET['lang'] ?>"><?= $lang['Inicio'] ?></a>
                </li>
                <li><?= $lang['Tabla Categorias']['Titulo'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?= $lang['Tabla Categorias']['Titulo']; ?></h4>
            <a href="<?= "Ccats.php?menu=1&lang=" . $_GET['lang'] ?>" class="New_Button"><?php echo $lang['Nueva Categoria']['Boton'] ?></a>
            <button name="Borrar" class="Borrar" onclick="cargarModal(2);changeModal()"><i class="icofont-delete-alt"></i> <?= $lang['Tabla Marcas']['Borrar']; ?></button>
            <button type="submit" name="Editar" class="Editar" form="Categorias"><i class="icofont-edit-alt"></i> <?= $lang['Tabla Usuarios']['Editar']; ?></button>
        </div>
        <form method="POST" id="Categorias">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th> <label for="selectAll"><?= $lang['seleccionarTodos'] ?></label><input type="checkbox" id="selectAll"></th>
                        <th><?= $lang['Tabla Categorias']['Nombre']; ?></th>
                        <th><?= $lang['Tabla Categorias']['Descripcion']; ?></th>
                        <th>Ver Subcategorias</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($cats && $categoria->getAll()->rowCount() > 0) {
                        foreach ($cats as $fila) {
                    ?>
                            <tr>
                                <td><input type="checkbox" name="<?= escapar($fila["idCategoria"]); ?>" id="<?= escapar($fila["idCategoria"]); ?>" class="option"></td>
                                <td><label for="<?= escapar($fila["idCategoria"]); ?>"><?= escapar($fila["nombre"]); ?></label>
                                </td>
                                <td><label for="<?= escapar($fila["idCategoria"]); ?>"><?= escapar($fila["descripcion"]) ?></label>
                                </td>
                                <td><a href="<?= 'Ccats.php?menu=4&idCat=' . escapar($fila["idCategoria"]) . "&lang=" . $_GET['lang']  ?>" class="Special"><i class="icofont-list"></i> Ver</a></td>
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