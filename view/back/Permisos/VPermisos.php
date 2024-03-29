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
    <?php require_once $_SESSION['WORKING_PATH'] . "view/back/cabecera.php"; ?>
  </div>
  <div class="sidebar">
    <?php include $_SESSION['WORKING_PATH'] . "view/back/menu.php"; ?>
  </div>
  <div class="contenedor">
    <div class="breadcrumb">
      <ul>
        <li><a href="<?= $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=3&lang=" . $_GET['lang'] ?>"><?= $lang['Inicio'] ?></a></li>
        <li><a href="<?= $_SESSION['INDEX_PATH'] . "controller/back/BCcontrol.php?menu=1&lang=" . $_GET['lang'] ?>"><?= $lang['Tabla Usuarios']['Titulo'] ?></a></li>
        <li><?= $lang['Tabla Usuarios']['Permisos'] ?></li>
      </ul>
    </div>
    <div class="contenido">
      <h4><?php echo $lang['Tabla Usuarios']['Permisos'] . ": " . $usuario->searchRow($_GET['id'])->getNick();  ?></h4>
    </div>
    <form method="POST" class="permisos">
      <ul>
        <?php foreach ($nombrePermiso as $fila => $clave) {
          if ($clave['columnaPadre'] == null) {
            $hijos = $usuario->getForeignValue('columnasmenu', null, $clave['idCol'], 'columnaPadre');
            if (sizeof($hijos) > 0) { ?>
              <li>
                <label for="<?= $clave['nombre'] ?>"><?= $clave['nombre'] ?></label>
                <?php if (in_array($clave['idCol'], array_column($permisos, 'permiso')) !== false) { ?>
                  <input checked type="checkbox" name="<?= $clave['nombre'] ?>" id="<?= $clave['nombre'] ?>" class="option">
                <?php } else { ?>
                  <input type="checkbox" name="<?= $clave['nombre'] ?>" id="<?= $clave['nombre'] ?>" class="option">
                <?php } ?>
                <ul>
                  <?php foreach ($hijos as $row) { ?>
                    <li>
                      <label for="<?= $row['nombre'] ?>"><?= $row['nombre'] ?></label>
                      <?php if (in_array($row['idCol'], array_column($permisos, 'permiso')) !== false) { ?>
                        <input checked type="checkbox" name="<?= $row['nombre'] ?>" class="subOption" id="<?= $row['nombre'] ?>">
                      <?php } else { ?>
                        <input type="checkbox" name="<?= $row['nombre'] ?>" class="subOption" id="<?= $row['nombre'] ?>">
                      <?php } ?>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } else {
            ?>
              <li>
                <label for="<?= $clave['nombre'] ?>"><?= $clave['nombre'] ?></label>
                <?php if (in_array($clave['idCol'], array_column($permisos, 'permiso')) !== false) { ?>
                  <input checked type="checkbox" name="<?= $clave['nombre'] ?>" id="<?= $clave['nombre'] ?>">
              </li>
            <?php } else { ?>
              <input type="checkbox" name="<?= $clave['nombre'] ?>" id="<?= $clave['nombre'] ?>"></li>
              <?php } ?><?php
                      }
                    }
                  } ?>
      </ul>
      <input type="submit" name="submit" value="<?= $lang['Nuevo Usuario']['Registrarse'] ?>">
      <input type="submit" name="cancelar" value="<?= $lang['Nuevo Usuario']['Cancelar'] ?>">
    </form>
  </div>
</body>

</html>
<script>
  var checkboxes = document.querySelectorAll('input.subOption'),
    checkall = document.getElementsByClassName('option');

  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].onclick = function() {
      var checkedCount = document.querySelectorAll('input.subOption:checked').length;
      if (!checkall[0].checked) {
        checkall[0].checked = checkedCount > 0;
        checkall[0].indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
      }
    }
  }

  checkall[0].onclick = function() {
    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = this.checked;
    }
  }
</script>