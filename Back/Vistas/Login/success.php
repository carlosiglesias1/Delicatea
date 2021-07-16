<?php
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}
$usuario = new Usuarios('usuarios');
$users = $usuario->getByID($_SESSION['id'])->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

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
        <?php
        include $_SESSION['WORKING_PATH'] . "Back/menu.php"; ?>
    </div>
    <div class="contenedor">
        Bienvenido <?php echo $users[0]['nick']; ?>
    </div>
</body>

</html>