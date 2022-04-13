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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($tiposIVA && sizeof($tiposIVA) > 0) {
                        foreach ($tiposIVA as $fila) {
                    ?>
                            <tr>
                                <td><input type="checkbox" name="<?= escapar($fila->getIdIva()); ?>" id="<?= escapar($fila->getIdIva()); ?>" class="option"></td>
                                <td><label for="<?= escapar($fila->getIdIva()); ?>"><?= escapar($fila->getTipo()); ?></label></td>
                                <td><label for="<?= escapar($fila->getIdIva()); ?>"><?= escapar($fila->getPorcentage()) ?></label></td>
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