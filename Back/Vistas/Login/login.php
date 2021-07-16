<?php
if (isset($_POST['submit'])) {
    if (session_status() == PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    $name = $_POST['username'];
    $password = "";
    if (isset($_POST["password"]))
        $password = substr(hash("sha512", $_POST['password']),0,50);
    try {
        logIn($name, $password);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicatea</title>
</head>

<body>
    <div class="cabecera">
        <?php //require_once $_SESSION['WORKING_PATH'] . "Back/cabecera.php"; 
        ?>
    </div>
    <div class="contenedor">
        <form method="post">
            <label for="username"><?php echo $lang['Nuevo Usuario']['Nombre']; ?></label>
            <input type="text" name="username">
            <label for="password"><?php echo $lang['Nuevo Usuario']['Contraseña'] ?></label>
            <input type="password" name="password">
            <input type="submit" name="submit">
        </form>
    </div>
</body>

</html>