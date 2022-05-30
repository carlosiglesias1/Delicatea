<?php
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}
?>
<!DOCTYPE html>
<html lang="en">

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
    <?php
    include $_SESSION['WORKING_PATH'] . "view/back/menu.php"; ?>
  </div>
  <div class="contenedor">
    <h1 class="welcome_message">Bienvenido de nuevo <?php echo $users->getNick(); ?></h1>
  </div>
</body>

</html>