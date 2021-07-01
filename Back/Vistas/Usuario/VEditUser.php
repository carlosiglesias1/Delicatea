<!DOCTYPE html>
<form method="POST">
    <label for="nickname">nickname</label>
    <input type="text" name="nickname" value="<?php echo escapar($campos['nick']) ?>">
    <button name="submit" type="submit"><?php if ($_GET['menu'] == 1) {
                                            echo "Registrarse";
                                        } else {
                                            echo "Actualizar";
                                        } ?></button>
    <button name="cancelar"><a href="BCcontrol.php?menu=1">Cancelar</a></button>
</form>