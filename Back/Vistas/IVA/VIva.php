<?php
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
$tipoIVA = new IVA();
$tiposIVA = $tipoIVA->getAll()->fetchAll(PDO::FETCH_ASSOC);
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
                <li><?= $lang['Nuevo Usuario']['Boton'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?= $lang['Tabla IVA']['Titulo']; ?></h4>
            <a href="<?= "Cusers.php?menu=1&lang=" . $_GET['lang'] ?>" class="New_Button"><?php echo $lang['Nuevo Usuario']['Boton'] ?></a>
        </div>
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th><?= $lang['Tabla IVA']['ID']; ?></th>
                    <th><?= $lang['Tabla IVA']['Tipo']; ?></th>
                    <th><?= $lang['Tabla IVA']['Porcentage']; ?></th>
                    <th><?= $lang['Tabla IVA']['Recargo'] ?></th>
                    <th><?= $lang['Tabla IVA']['Acciones']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($tiposIVA && $tipoIVA->getAll()->rowCount() > 0) {
                    foreach ($tiposIVA as $fila) {
                ?>
                        <tr>
                            <td><?php echo escapar($fila["idIva"]); ?></td>
                            <td><?php echo escapar($fila["tipo"]); ?></td>
                            <td><?php echo escapar($fila["porcentage"]) ?></td>
                            <td><?= escapar($fila["recargoEquivalencia"]) ?></td>
                            <td class="options">
                                <a href="<?= 'CIva.php?menu=2&id=' . escapar($fila["idIva"]) ?>" onclick="return confirmar('<?php echo $lang['confirmacion']; ?>')" class="Borrar"><i class="icofont-delete-alt"></i> <?= $lang['Tabla IVA']['Borrar']; ?></a>
                                <a href="<?= 'CIva.php?menu=3&id=' . escapar($fila["idIva"]) . "&lang=" . $_GET['lang'] ?>" class="Editar"><i class="icofont-edit-alt"></i> <?= $lang['Tabla IVA']['Editar']; ?></a>
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