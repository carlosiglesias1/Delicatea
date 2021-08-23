<?php
require_once "../Lenguajes/config.php";
$modo = $_GET['modo'];
//Modo 1 representa el formulario de login
switch ($modo) {
    case 1: ?>
        <div class="modal-contenido">
            <form method="post">
                <label for="username"><?= $lang['Nuevo Usuario']['Nombre'] ?></label>
                <input type="text" name="username" id="username">
                <label for="password"><?= $lang['Nuevo Usuario']['Contraseña'] ?></label>
                <input type="password" name="password" id="password">
                <input type="submit" name="submit">
            </form>
        </div>
    <?php
        break;
    case 2: ?>
        <div class="modal-contenido">
            <span class="close" onclick="changeModal()"><i class="icofont-close-circled"></i></span>
            <h4 class="confirm"><?= $lang['confirmacion'] ?></h4>
            <input type="submit" name="confirmar" class="btn-confirm" value="<?= $lang['Botones']['delete-confirm'] ?>">
            <span class="btn-regect" onclick="changeModal()"><?= $lang['Botones']['delete-regect'] ?></span>
        </div>
    <?php
        break;
    case 3: ?>
        <div class="modal-contenido">
            <span class="close" onclick="changeModal()"><i class="icofont-close-circled"></i></span>
            <h4><?= $lang['Errores']['error-edicion'] ?></h4>
        </div>
<?php
}
?>