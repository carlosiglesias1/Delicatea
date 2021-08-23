<?php
require_once 'cabecera.php';
?>
<nav class="menusidebar">
    <ul>
        <?php
        foreach ($_SESSION['ventanasMenu'] as $fila) {
            switch ($fila['permiso']) {
                case 1:
        ?><li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=1&lang=' . $_GET['lang'] ?>"><i class="icofont-ui-user"></i> <?php echo $lang['Menu BackOffice']['Usuarios'] ?></a></li>
                <?php break;
                case 2:
                ?><li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=2&lang=' . $_GET['lang'] ?>"><i class="icofont-bar-code"></i> <?php echo $lang['Menu BackOffice']['Marcas'] ?></a></li>
                <?php break;
                case 3:
                ?><li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=6&lang=' . $_GET['lang'] . "&idTarifa=0" ?>"><?php echo $lang['Menu BackOffice']['Articulos'] ?></li>
                <?php break;
                case 4:
                ?><li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=5&lang=' . $_GET['lang'] ?>"><i class="icofont-ui-folder"></i> <?php echo $lang['Menu BackOffice']['Categorias'] ?></a>
                    <?php break;
                case 5:
                    ?><ul>
                            <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=4&lang=' . $_GET['lang'] . "&idCat=0" ?>"><i class="icofont-search-folder"></i> <?php echo $lang['Menu BackOffice']['Subcategorias'] ?></a></li>
                        </ul>
                    </li>
                <?php break;
                case 6:
                ?><li><?php echo $lang['Menu BackOffice']['Clientes'] ?></li>
                <?php break;
                case 7:
                ?><li><?php echo $lang['Menu BackOffice']['Facturas'] ?></li>
                <?php break;
                case 8:
                ?><li><?php echo $lang['Menu BackOffice']['Ventas'] ?></li>
                <?php break;
                case 9:
                ?><li><?php echo $lang['Menu BackOffice']['Contabilidad'] ?></li>
                <?php break;
                case 10:
                ?><li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=7&lang=' . $_GET['lang'] ?>"><i class="icofont-sale-discount"></i> <?php echo $lang['Menu BackOffice']['IVA'] ?></a></li>
                <?php break;
                case 11:
                ?><li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=8&lang=' . $_GET['lang'] ?>"><?= $lang['Menu BackOffice']['Tarifas'] ?></a></li>
        <?php break;
            }
        } ?>
    </ul>
</nav>