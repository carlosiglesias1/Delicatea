<?php
    require_once $_SESSION['WORKING_PATH'] . "lang/config.php";
?>
<!DOCTYPE html>
<html lang="<?= $_GET['lang'] ?>">
<head>
    <title>Delicatea</title>
    <link rel="stylesheet" href="<?php echo  $_SESSION['INDEX_PATH'] . "icofont/icofont.min.css"; ?>">
    <link rel="stylesheet" href="<?php echo  $_SESSION['INDEX_PATH'] . 'view/back/styles/Estilos.css'; ?>">
    <script src="<?= $_SESSION['INDEX_PATH'] . 'Includes/jquery-3.5.1.js' ?>"></script>
    <script src="<?= $_SESSION['INDEX_PATH'] . 'Includes/DataTables/dataTables.min.js' ?>"></script>
</head>

<div class="cabecera">
    <nav class="menucabecera">
        <ul>
            <li>Idiomas
                <ul>
                    <li><a href="<?= "http://" . $_SERVER['HTTP_HOST'] . str_replace("lang=" . $_GET['lang'], "lang=es", $_SERVER['REQUEST_URI']) ?>"><?php echo $lang['es'] ?></a></li>
                    <li><a href="<?= "http://" . $_SERVER['HTTP_HOST'] . str_replace("lang=" . $_GET['lang'], "lang=en", $_SERVER['REQUEST_URI']) ?>"><?php echo $lang['en'] ?></a></li>
                    <li><a href="<?= "http://" . $_SERVER['HTTP_HOST'] . str_replace("lang=" . $_GET['lang'], "lang=gl", $_SERVER['REQUEST_URI']) ?>"><?php echo $lang['gl'] ?></a></li>
                </ul>
            </li>
            <li>Usuario
                <ul>
                    <li><a href="BCcontrol.php?menu=0&lang= <?= $_GET['lang'] ?>" class="logOut"><?php echo $lang['Log Out'] ?></a></li>
                </ul>
            </li>
            <li>
                <a href="BCcontrol.php?menu=0&lang=<?= $_GET['lang'] ?>" class="logOutIcon"><i class="icofont-logout"></i></a>
            </li>
            </li>
        </ul>
    </nav>
</div>