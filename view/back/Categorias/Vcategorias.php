<?php
csrf();
if (isset($_POST['mit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
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
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=3&lang=" . $_GET['lang'] ?>"><?= $lang['Inicio'] ?></a>
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
                        <th> <label for="selectAll"><?= $lang['seleccionarTodos'] ?></label><input type="checkbox" id="selectAll" style="display: none;"></th>
                        <th><?= $lang['Tabla Categorias']['Nombre']; ?></th>
                        <th><?= $lang['Tabla Categorias']['Descripcion']; ?></th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($cats && sizeof($categoria->getList()) > 0) {
                        foreach ($cats as $fila) {
                    ?>
                            <tr>
                                <td><label>
                                        <input type="checkbox" name="<?= $fila->getIdCategoria() ?>" id="<?= escapar($fila->getIdCategoria()); ?>" class="option">
                                        <span class="checkbox"></span>
                                    </label>
                                </td>
                                <td><label for="<?= escapar($fila->getIdCategoria()); ?>"><?= escapar($fila->getNombre()); ?></label>
                                </td>
                                <td><label for="<?= escapar($fila->getIdCategoria()); ?>"><?= escapar($fila->getDescripcion()) ?></label>
                                </td>
                                <td><a href="<?= 'Ccats.php?menu=4&idCat=' . escapar($fila->getIdCategoria()) . "&lang=" . $_GET['lang']  ?>" class="Special"><i class="icofont-list"></i>Ver Subcategorias</a></td>
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