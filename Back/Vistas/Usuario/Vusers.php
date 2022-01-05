<?php
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Delicatea</title>
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
                <li><?= $lang['Tabla Usuarios']['Titulo'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?= $lang['Tabla Usuarios']['Titulo']; ?></h4>
            <a href="<?= "Cusers.php?menu=1&lang=" . $_GET['lang'] ?>" class="New_Button"><?php echo $lang['Nuevo Usuario']['Boton'] ?></a>
            <button class="Borrar" onclick="cargarModal(2);changeModal()"><em class="icofont-delete-alt"></em> <?= $lang['Tabla Usuarios']['Borrar'] ?></button>
            <button type="submit" name="Editar" class="Editar" form="Usuarios"><em class="icofont-edit-alt"></em> <?= $lang['Tabla Usuarios']['Editar']; ?></button>
        </div>
        <form method="POST" id="Usuarios">
            <table id="myTable" class="display">
                <caption>PRODUCTOS</caption>
                <thead>
                    <tr>
                        <th class="selectAll" scope="selectAll"><label for="selectAll">Seleccionar todos</label><input type="checkbox" id="selectAll"></th>
                        <th scope="name"><?= $lang['Tabla Usuarios']['Nickname']; ?></th>
                        <th scope="administration"><?= $lang['Tabla Usuarios']['Gestion'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($users && sizeof($users) > 0) {
                        foreach ($users as $value) {
                    ?>
                            <tr>
                                <td><input type="checkbox" name="<?= $value->getIdUsr() ?>" id="<?= escapar($value->getIdUsr()); ?>" class="option"></td>
                                <td><label for="<?= $value->getIdUsr() ?>"><?php echo escapar($value->getNick()); ?></td></label>
                                <td><a href="<?= 'Cusers.php?menu=4&id=' . escapar($value->getIdUsr()) . "&lang=" . $_GET['lang'] ?>"><?= $lang['Tabla Usuarios']['Ver'] ?></a></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                <tbody>
            </table>
            <?php if (isset($_SESSION['error'])) {
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