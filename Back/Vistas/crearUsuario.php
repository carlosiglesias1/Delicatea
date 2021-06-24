<?php
    include '../Controladores/exitoCreacion.php'
?>

<!DOCTYPE html>
<form method="POST">
    <label for="nickname">nickname</label>
    <input type="text" name="nickname">
    <label for="password">Password</label>
    <input type="text" name="password">
    <label for="RepPassword">Repetir Password</label>
    <input type="text" name="repPassword">
    <button name = "submit" type="submit" value="Registrarse">Registrarse</button>
</form>