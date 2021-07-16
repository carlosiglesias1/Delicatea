<?php
require_once 'cabecera.php'; ?>
<?php
switch ($_SESSION['menu']) {
    case 1:
?>
        <ul>
            <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=1&lang=' . $_GET['lang'] ?>"><i class="icofont-ui-user"></i> <?php echo $lang['Menu BackOffice']['Usuarios'] ?></a></li>
            <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=2&lang=' . $_GET['lang'] ?>"><i class="icofont-bar-code"></i> <?php echo $lang['Menu BackOffice']['Marcas'] ?></a></li>
            <li><?php echo $lang['Menu BackOffice']['Productos'] ?></li>
            <li><?php echo $lang['Menu BackOffice']['Categorias'] ?></li>
            <li><a href="<?=$_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=4&lang=' . $_GET['lang'] ?>"><?php echo $lang['Menu BackOffice']['Subcategorias'] ?></a></li>
            <li><?php echo $lang['Menu BackOffice']['Clientes'] ?></li>
            <li><?php echo $lang['Menu BackOffice']['Facturas'] ?></li>
            <li><?php echo $lang['Menu BackOffice']['Ventas'] ?></li>
            <li><?php echo $lang['Menu BackOffice']['Contabilidad'] ?></li>
        </ul>
    <?php
        break;
    case 2:
    ?>
        <ul>
            <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=2&lang=' . $_GET['lang'] ?>"><i class="icofont-bar-code"></i> <?php echo $lang['Menu BackOffice']['Marcas'] ?></a></li>
            <li> <?php echo $lang['Menu BackOffice']['Productos'] ?></li>
            <li><a href="<?=$_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=4&lang=' . $_GET['lang'] ?>"><?php echo $lang['Menu BackOffice']['Subcategorias'] ?></a></li>
            <li><?php echo $lang['Menu BackOffice']['Subcategorias'] ?></li>
            <li><?php echo $lang['Menu BackOffice']['Clientes'] ?></li>
        </ul>
    <?php
        break;
    case 3:
    ?>
        <ul>
            <li><?php echo $lang['Menu BackOffice']['Clientes'] ?></li>
            <li><?php echo $lang['Menu BackOffice']['Facturas'] ?></li>
        </ul>
<?php
        break;
    default:
        echo "Your usrRol rest in peace, NOW YOU CAN'T SEE NOTHING";
        break;
}
?>