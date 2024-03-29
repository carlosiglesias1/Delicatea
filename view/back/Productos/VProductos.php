<?php
csrf();
if (isset($_POST['mit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}
$_SESSION['WORKING_PATH'] . 'paths/NewPaths.php';
?>

<body>
  <?php require_once $_SESSION['WORKING_PATH'] . 'view/back/cabecera.php'; ?>
  <div class="sidebar">
    <?php include $_SESSION['WORKING_PATH'] . 'view/back/menu.php'; ?>
  </div>
  <div class="contenedor">
    <div class="breadcrumb">
      <ul>
        <li><a href="<?= $_SESSION['INDEX_PATH'] .
                        'Back/Controladores/BCcontrol.php?menu=3&lang=' .
                        $_GET['lang'] ?>"><?= $lang['Inicio'] ?></a></li>
        <?php if ($_GET['idTarifa'] != 0) { ?>
          <li><a href="<?= $_SESSION['INDEX_PATH'] .
                          'Back/Controladores/BCcontrol.php?menu=8&lang=' .
                          $_GET['lang'] ?>"><?= $lang['Tabla Tarifas']['Titulo'] ?></a></li>
        <?php } ?>
        <li><?= $lang['Tabla Articulos']['Titulo'] ?></li>
      </ul>
    </div>
    <div class="contenido">
      <h4><?php if ($_GET['idTarifa'] != 0) {
            //echo $lang['Tabla Articulos']['Titulo'] . ': ' . $tarifaName->getNombre();
          } else {
            echo $lang['Tabla Articulos']['Titulo'];
          } ?></h4>
      <a href="<?= 'Cprods.php?menu=1&lang=' . $_GET['lang'] . '&idTarifa=' . $_GET['idTarifa'] ?>" class="New_Button"><?php echo $lang['Nuevo Articulo']['Boton']; ?></a>
      <button class="Borrar" name="Borrar" onclick="cargarModal(2); changeModal()"><i class="icofont-delete-alt"></i> <?= $lang['Tabla Articulos']['Borrar'] ?></button>
      <?php if ($_GET['idTarifa'] != 0) { ?>
        <a href="<?= $_SESSION['INDEX_PATH'] . 'controller/back/BCcontrol.php?menu=8&lang=' . $_GET['lang'] ?>" class="return"><?= $lang['Tabla Tarifas']['Volver'] ?></a>
      <?php } ?>
    </div>
    <form method="post">
      <table id="myTable" class="display">
        <thead>
          <tr>
            <th><label for="selectAll"><?= $lang['seleccionarTodos'] ?></label> <input type="checkbox" id="selectAll" style="display: none;"></th>
            <th> </th>
            <th><?= $lang['Tabla Articulos']['Nombre'] ?></th>
            <th><?= $lang['Tabla Articulos']['Descripcion'] ?></th>
            <th>Coste</th>
            <?php if ($_GET['idTarifa'] != 0) { ?>
              <th>Precio Final</th>
            <?php } ?>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php if ($prods && sizeof($articulo->getAll()) > 0) {
            foreach ($prods as $fila) { ?>
              <tr>
              <td><label>
                    <input type="checkbox" name="<?= $fila->getIdArticulo() ?>" id="<?= escapar($fila->getIdArticulo()); ?>" class="option">
                    <span class="checkbox"></span>
                  </label>
                </td>
                <td><label for="<?= escapar($fila->getIdArticulo()) ?>"><img src="http://localhost:444/Delicatea/imgs/articulos/46/artworks-fBvQUKQfO8Kervzy-PnlM0g-t500x500.jpg" alt="" height="60px"><label for="<?= escapar($fila->getIdArticulo()) ?>"></td>
                <td><label for="<?= escapar($fila->getIdArticulo()) ?>"><?php echo escapar($fila->getNombre()); ?></label></td>
                <td><label for="<?= escapar($fila->getIdArticulo()) ?>"><?php echo escapar($fila->getDescripcionCorta()); ?></label></td>
                <td><label for="<?= escapar($fila->getIdArticulo()) ?>"><?= escapar($fila->getCoste()) ?></label></td>
                <?php if ($_GET['idTarifa'] != 0) { ?>
                  <td><label for="<?= escapar(
                                    $fila->getIdArticulo()
                                  ) ?>"><?= 'wait' ?></label></td>
                <?php } ?>
                <td class="options">
                  <a href="<?= 'Cprods.php?menu=3&id=' . escapar($fila->getIdArticulo()) . '&lang=' . $_GET['lang'] . '&idTarifa=' . $_GET['idTarifa'] ?>" class="Editar">
                    <i class="icofont-edit-alt"></i> <?= $lang['Tabla Articulos']['Editar'] ?></a>
                </td>
              </tr>
          <?php }
          } ?>
        <tbody>
      </table>
      <?php
      if (
        isset($_SESSION['error'])
      ) { ?> <div class="modal abrir" id="modal">
          <script>
            cargarModal(<?= $_SESSION['error'] ?>)
          </script>
        </div> <?php } else { ?>
        <div class="modal" id="modal">
        </div><?php }
              unset($_SESSION['error']);
              ?>
    </form>
  </div>
</body>

</html>
<!--Scripts-->
<script>
  selectInit();
  dataTableInit();
</script>