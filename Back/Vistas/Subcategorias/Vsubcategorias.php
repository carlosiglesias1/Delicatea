<?php
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
$subcategoria = new SubCategoria('subcategoria');
$subcats = $subcategoria->getAll()->fetchAll(PDO::FETCH_ASSOC);
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
                <li><?= $lang['Nuevo subcategoria']['Boton'] ?></li>
            </ul>
        </div>
        <div class="contenido">
            <h4><?= $lang['Tabla subcategorias']['Titulo']; ?></h4>
            <a href="<?= "Csubcats.php?menu=1&lang=" . $_GET['lang'] ?>" class="New_Button"><?php echo $lang['Nueva subcategoria']['Boton'] ?></a>
        </div>
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th><?= $lang['Tabla subcategorias']['ID']; ?></th>
                    <th><?= $lang['Tabla subcategorias']['Nickname']; ?></th>
                    <th><?= $lang['Tabla subcategorias']['Rol']; ?></th>
                    <th><?= $lang['Tabla subcategorias']['Acciones']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($subcats && $subcategoria->getAll()->rowCount() > 0) {
                    foreach ($subcats as $fila) {
                ?>
                        <tr>
                            <td><?php echo escapar($fila["idUsr"]); ?></td>
                            <td><?php echo escapar($fila["nick"]); ?></td>
                            <td><?php echo $subcategoria->getRol($fila["rol"])[0]['nombre']; ?></td>
                           <td class="options">
                                <a href="<?= 'Csubcats.php?menu=2&campo=idUsr&id=' . escapar($fila["idUsr"]) ?>" onclick="return confirmar('<?php echo $lang['confirmacion']; ?>')" class="Borrar"><i class="icofont-delete-alt"></i> <?= $lang['Tabla subcategorias']['Borrar']; ?></a>
                                <a href="<?= 'Csubcats.php?menu=3&id=' . escapar($fila["idUsr"]) . "&lang=" . $_GET['lang'] ?>" class="Editar"><i class="icofont-edit-alt"></i> <?= $lang['Tabla subcategorias']['Editar']; ?></a>
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