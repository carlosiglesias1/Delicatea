<!DOCTYPE html>
<form method="POST">
    <label for="nickname">nickname</label>
    <input type="text" name="nickname">
    <label for="password">Password</label>
    <input type="text" name="password">
    <label for="RepPassword">Repetir Password</label>
    <input type="text" name="repPassword">
    <button name="submit" type="submit"><?php if ($_GET['menu'] == 1) {
                                            echo "Registrarse";
                                        } else {
                                            echo "Actualizar";
                                        } ?></button>
    <button name="cancelar"><a href="BCcontrol.php?menu=1">Cancelar</a></button>
</form>