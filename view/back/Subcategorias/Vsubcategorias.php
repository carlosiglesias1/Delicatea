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
                <?php
                if ($_GET['idCat'] != 0) {
                ?>
                    <li><a href="<?= $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=5&lang=" . $_GET['lang'] ?>"><?= $lang['Tabla Categorias']['Titulo'] ?></a></li>
                <?php
                } ?>
                <li><?= $lang['Tabla Subcategorias']['Titulo'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?php if ($_GET['idCat'] == 0) {
                    echo $lang['Tabla Subcategorias']['Titulo'];
                } else {
                    echo $lang['Tabla Subcategorias']['Titulo'] . " :  " . $nombreCat;
                } ?></h4>
            <a href="<?= "Csubcats.php?menu=1&lang=" . $_GET['lang'] . '&idCat=' . $_GET['idCat'] ?>" class="New_Button"><?php echo $lang['Nueva Subcategoria']['Boton'] ?></a>
            <button onclick="cargarModal(2);changeModal()" class="Borrar"></em class="icofont-delete-alt"><?= $lang['Tabla Subcategorias']['Borrar']; ?></button>
            <button type="submit" class="Editar" name="Editar" form="SubCats"></em class="icofont-edit-alt"> <?= $lang['Tabla Subcategorias']['Editar']; ?></button>
            <?php if ($_GET['idCat'] != 0) { ?>
                <a href="<?= $_SESSION['INDEX_PATH'] . 'controller/back/BCcontrol.php?menu=5&lang=' . $_GET['lang'] ?>" class="return"><?= $lang['Tabla Subcategorias']['Volver'] ?></a>
            <?php } ?>
        </div>
        <form method="POST" id="SubCats">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th><label for="selectAll">Seleccionar Todos</label><input type="checkbox" id="selectAll"></th>
                        <th><?= $lang['Tabla Subcategorias']['Nombre']; ?></th>
                        <th><?= $lang['Tabla Subcategorias']['Descripcion']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (sizeof($subcats) > 0) {
                        foreach ($subcats as $fila) {
                    ?>
                            <tr>
                                <td><input type="checkbox" name="<?= $fila->getIdSubCategoria() ?>" id="<?= $fila->getIdSubCategoria() ?>" class="option"></td>
                                <td><label for="<?= escapar($fila->getIdSubCategoria()) ?>"><?= escapar($fila->getNombre()); ?></label></td>
                                <td><label for="<?= escapar($fila->getIdSubCategoria()) ?>"><?= escapar($fila->getDescripcion()) ?></label></td>
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
    selectInit();
</script>