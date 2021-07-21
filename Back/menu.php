<?php
require_once 'cabecera.php'; ?>
<?php
switch ($_SESSION['menu']) {
    case 1:
?>
        <nav class="menusidebar">
            <ul>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=1&lang=' . $_GET['lang'] ?>"><i class="icofont-ui-user"></i> <?php echo $lang['Menu BackOffice']['Usuarios'] ?></a></li>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=2&lang=' . $_GET['lang'] ?>"><i class="icofont-bar-code"></i> <?php echo $lang['Menu BackOffice']['Marcas'] ?></a></li>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=6&lang=' . $_GET['lang'] ?>"><?php echo $lang['Menu BackOffice']['Articulos'] ?></li>
                <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=5&lang=' . $_GET['lang'] ?>"><i class="icofont-ui-folder"></i> <?php echo $lang['Menu BackOffice']['Categorias'] ?></a>
                    <ul>
                        <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=4&lang=' . $_GET['lang'] . "&idCat=0"?>"><i class="icofont-search-folder"></i> <?php echo $lang['Menu BackOffice']['Subcategorias'] ?></a></li>
                    </ul>
                </li>
                <li><?php echo $lang['Menu BackOffice']['Clientes'] ?></li>
                <li><?php echo $lang['Menu BackOffice']['Facturas'] ?></li>
                <li><?php echo $lang['Menu BackOffice']['Ventas'] ?></li>
                <li><?php echo $lang['Menu BackOffice']['Contabilidad'] ?></li>
                <li><a href="#openModal">Abrir modal</a></li>
            </ul>
        </nav>
        <div id="openModal" class="modalDialog">
            <div>
                <a href="#close" title="Close" class="close">X</a>
                <h2>modal</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia beatae, libero. Magni distinctio quas aut voluptates eos, qui harum blanditiis est recusandae quasi, cum explicabo. Architecto atque possimus doloribus officiis?</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolorem, exercitationem. Iste excepturi cum voluptates minus nesciunt, ad atque modi illo doloremque, ducimus officiis aliquid, nemo veritatis, facilis voluptas ipsa qui!</p>
            </div>
        </div>
    <?php
        break;
    case 2:
    ?>
        <ul>
            <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=2&lang=' . $_GET['lang'] ?>"><i class="icofont-bar-code"></i> <?php echo $lang['Menu BackOffice']['Marcas'] ?></a></li>
            <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=6&lang=' . $_GET['lang'] ?>"><?php echo $lang['Menu BackOffice']['Articulos'] ?></li>
            <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=5&lang=' . $_GET['lang'] ?>"><i class="icofont-ui-folder"></i> <?php echo $lang['Menu BackOffice']['Categorias'] ?></a></li>
            <li><a href="<?= $_SESSION['INDEX_PATH'] . 'Back/Controladores/BCcontrol.php?menu=4&lang=' . $_GET['lang'] ?>"><i class="icofont-search-folder"></i> <?php echo $lang['Menu BackOffice']['Subcategorias'] ?></a></li>
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