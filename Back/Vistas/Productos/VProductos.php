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
                <li><a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=3&lang=" . $_GET['lang'] ?>"><?= $lang['Inicio'] ?></a></li>
                <?php
                if ($_GET['idTarifa'] != 0) {
                ?>
                    <li><a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=8&lang=" . $_GET['lang'] ?>"><?= $lang['Tabla Tarifas']['Titulo'] ?></a></li>
                <?php
                }
                ?>
                <li><?= $lang['Tabla Articulos']['Titulo'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?php if ($_GET['idTarifa'] != 0) {
                    echo $lang['Tabla Articulos']['Titulo'] . ": " . $articulo->getById($_GET['idTarifa'])->fetchAll(PDO::FETCH_ASSOC)[0]['nombre'];
                } else {
                    echo $lang['Tabla Articulos']['Titulo'];
                } ?></h4>
            <a href="<?= "Cprods.php?menu=1&lang=" . $_GET['lang']."&idTarifa=".$_GET['idTarifa']?>" class="New_Button"><?php echo $lang['Nuevo Articulo']['Boton'] ?></a>
            <button class="Borrar" name="Borrar" onclick="cargarModal(2); changeModal()"><?= $lang['Tabla Articulos']['Borrar']; ?></button>
            <?php if ($_GET['idTarifa'] != 0) { ?>
                <a href="<?= $_SESSION['INDEX_PATH'] . "Back/Controladores/BCcontrol.php?menu=8&lang=" . $_GET['lang'] ?>" class="return"><?= $lang['Tabla Tarifas']['Volver'] ?></a>
            <?php } ?>
        </div>
        <form method="post">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th><label for="selectAll"><?= $lang['seleccionarTodos']?></label> <input type="checkbox" id="selectAll"></th>
                        <th><?= $lang['Tabla Articulos']['Nombre']; ?></th>
                        <th><?= $lang['Tabla Articulos']['Descripcion']; ?></th>
                        <th>Coste</th>
                        <?php
                        if ($_GET['idTarifa'] != 0) {
                        ?>
                            <th>Precio Final</th>
                        <?php } ?>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($prods && $articulo->getAll()->rowCount() > 0) {
                        foreach ($prods as $fila) {
                    ?>
                            <tr>
                                <td><input type="checkbox" name="<?= escapar($fila['idArticulo']) ?>" id="<?= escapar($fila['idArticulo']) ?>" class="option"></td>
                                <td><label for="<?= escapar($fila['idArticulo']) ?>"><?php echo escapar($fila["nombre"]); ?></label></td>
                                <td><label for="<?= escapar($fila['idArticulo']) ?>"><?php echo escapar($fila["descripcionCorta"]) ?></label></td>
                                <td><label for="<?= escapar($fila['idArticulo']) ?>"><?= escapar($fila['coste']) ?></label></td>
                                <?php
                                if ($_GET['idTarifa'] != 0) {
                                ?>
                                    <td><label for="<?= escapar($fila['idArticulo']) ?>"><?= escapar($fila['costeFinal']) ?></label></td>
                                <?php } ?>
                                <td class="options">
                                    <a href="<?= 'Cprods.php?menu=3&id=' . escapar($fila["idArticulo"]) . "&lang=" . $_GET['lang'] . "&idTarifa=" . $_GET['idTarifa'] ?>" class="Editar"><i class="icofont-edit-alt"></i> <?= $lang['Tabla Articulos']['Editar']; ?></a>
                                </td>
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