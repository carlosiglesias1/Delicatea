<?php
require_once 'cabecera.php';
$RUTA = 'controller/back/BCcontrol.php?';
?>
<nav class="menusidebar">
  <ul>
    <?php
    foreach ($_SESSION['ventanasMenu'] as $fila) {
      switch ($fila['permiso']) {
        case 1:
    ?><li><a href="<?= $_SESSION['INDEX_PATH'] . $RUTA . 'menu=1&lang=' . $_GET['lang'] ?>"><i class="icofont-ui-user"></i> <?php echo $lang['Menu BackOffice']['Usuarios'] ?></a></li>
        <?php break;
        case 2:
        ?><li><a href="<?= $_SESSION['INDEX_PATH'] . $RUTA . 'menu=2&lang=' . $_GET['lang'] ?>"><i class="icofont-bar-code"></i> <?php echo $lang['Menu BackOffice']['Marcas'] ?></a></li>
        <?php break;
        case 3:
        ?><li><a href="<?= $_SESSION['INDEX_PATH'] . $RUTA . 'menu=6&lang=' . $_GET['lang'] . "&idTarifa=0" ?>"><i class="icofont-cart-alt"></i><?php echo $lang['Menu BackOffice']['Articulos'] ?></a></li>
        <?php break;
        case 4:
        ?><li><a href="<?= $_SESSION['INDEX_PATH'] . $RUTA . 'menu=5&lang=' . $_GET['lang'] ?>"><i class="icofont-ui-folder"></i> <?php echo $lang['Menu BackOffice']['Categorias'] ?></a>
          <?php break;
        case 5:
          ?><ul>
              <li><a href="<?= $_SESSION['INDEX_PATH'] . $RUTA . 'menu=4&lang=' . $_GET['lang'] . "&idCat=0" ?>"><i class="icofont-search-folder"></i> <?php echo $lang['Menu BackOffice']['Subcategorias'] ?></a></li>
            </ul>
          </li>
        <?php break;
        case 6:
        ?><li><a href="<?= $_SESSION['INDEX_PATH'] . $RUTA . 'menu=1&lang=' . $_GET['lang'] ?>"><?php echo $lang['Menu BackOffice']['Clientes'] ?></a></li>
        <?php break;
        case 7:
        ?><li><a href="<?= $_SESSION['INDEX_PATH'] . $RUTA . 'menu=8&lang=' . $_GET['lang'] ?>"><?php echo $lang['Menu BackOffice']['Facturas'] ?></a></li>
        <?php break;
        case 8:
        ?><li><a href="<?= $_SESSION['INDEX_PATH'] . $RUTA . 'menu=8&lang=' . $_GET['lang'] ?>"><?php echo $lang['Menu BackOffice']['Ventas'] ?></a></li>
        <?php break;
        case 9:
        ?><li><a href="<?= $_SESSION['INDEX_PATH'] . $RUTA . 'menu=8&lang=' . $_GET['lang'] ?>"><?php echo $lang['Menu BackOffice']['Contabilidad'] ?></a></li>
        <?php break;
        case 10:
        ?><li><a href="<?= $_SESSION['INDEX_PATH'] . $RUTA . 'menu=7&lang=' . $_GET['lang'] ?>"><i class="icofont-sale-discount"></i> <?php echo $lang['Menu BackOffice']['IVA'] ?></a></li>
        <?php break;
        case 11:
        ?><li><a href="<?= $_SESSION['INDEX_PATH'] . $RUTA . 'menu=8&lang=' . $_GET['lang'] ?>"><i class="icofont-price"></i> <?= $lang['Menu BackOffice']['Tarifas'] ?></a></li>
    <?php break;
        default:
          echo "No hay menús disponibles";
          break;
      }
    } ?>
  </ul>
</nav>