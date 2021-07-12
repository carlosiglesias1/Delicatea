<?php
require_once 'cabecera.php'; ?>
<?php
switch ($_SESSION['menu']) {
    case 1:
?>
        <ul>
            <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=1&lang=' . $_GET['lang'] ?>"><i class="icofont-ui-user"></i> <?php echo $lang['Menu BackOffice']['Usuarios'] ?></a></li>
            <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=2&lang=' . $_GET['lang'] ?>"><i class="icofont-bar-code"></i> <?php echo $lang['Menu BackOffice']['Productos'] ?></a></li>
            <li>Marcas</li>
            <li>Categorias</li>
            <li>Subcategorias</li>
            <li>Clientes</li>
            <li>Facturas</li>
            <li>Ventas</li>
            <li>Contabilidad</li>
        </ul>
    <?php
        break;
    case 2:
    ?>
        <ul>
            <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=2&lang=' . $_GET['lang'] ?>"><i class="icofont-bar-code"></i> <?php echo $lang['Menu BackOffice']['Productos'] ?></a></li>
            <li>Marcas</li>
            <li>Categorias</li>
            <li>Subcategorias</li>
            <li>Clientes</li>
        </ul>
    <?php
        break;
    case 3:
    ?>
        <ul>
            <li>Clientes</li>
            <li>Facturas</li>
        </ul>
<?php
default: 
        echo "Your usrRol rest in peace, NOW YOU CAN'T SEE NOTHING";
        break;
}
?>