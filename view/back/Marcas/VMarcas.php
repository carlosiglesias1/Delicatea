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
                <li><?= $lang['Tabla Marcas']['Titulo'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?= $lang['Tabla Marcas']['Titulo']; ?></h4>
            <a href="<?= "Cmarks.php?menu=1&lang=" . $_GET['lang'] ?>" class="New_Button"><?php echo $lang['Nueva Marca']['Boton'] ?></a>
            <button name="Borrar" class="Borrar" onclick="cargarModal(2); changeModal()"><em class="icofont-delete-alt"></em> <?= $lang['Tabla Usuarios']['Borrar'] ?></button>
            <button type="submit" name="Editar" class="Editar" form="Marcas"><em class="icofont-edit-alt"></em> <?= $lang['Tabla Usuarios']['Editar']; ?></button>
        </div>
        <!--Para que dataTables funcione, debemos tener las mismas columnas en el thead que en tbody-->
        <form method="POST" id="Marcas">
            <table id="myTable" class="display trying">
                <caption>MARCAS</caption>
                <thead>
                    <tr>
                        <th class="selectAll" scope="selectAll"><label for="selectAll">Seleccionar todos</label><input type="checkbox" id="selectAll"></th>
                        <th scope="name"><?= $lang['Tabla Marcas']['Nombre'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($marcas && sizeof($marcas) > 0) {
                        foreach ($marcas as $fila) {
                    ?>
                            <tr>
                                <td><input type="checkbox" name="<?= $fila->getIdMarca() ?>" id="<?= escapar($fila->getIdMarca()); ?>" class="option"></td>
                                <td><label for="<?= escapar($fila->getIdMarca()); ?>"><?= escapar($fila->getNombre()); ?></label></td>
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
                </div><?php }
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