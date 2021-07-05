<?php
echo "Hola Mundo";
//Base Modelos
require_once 'Modelos/Mestandar.php';
require_once '../Lenguajes/config.php';
?>

<!DOCTYPE html>
<body style="background-color: gainsboro;">
<div>
    <ul>
        <li><a href="<?='Controladores/BCcontrol.php?menu=1&lang='. $_GET['lang']?>">Usuarios</a></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
</body>
<footer>
    <a href="menu.php?lang=es"><?php echo $lang['es']?></a>
    <a href="menu.php?lang=en"><?php echo $lang['en']?></a>
    <a href="menu.php?lang=gl"><?php echo $lang['gl']?></a>
    <?php echo $_SESSION['lang']; ?>
</footer>