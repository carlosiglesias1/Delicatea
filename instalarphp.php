<?php
$config = include 'Conexion/config.php';

try {
    $conexion = new PDO('mysql:host=' . $config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    $sql = file_get_contents("data/migracion.sql");

    $conexion->exec($sql);
    echo <?php echo $lang['Inicio'] ?>;
} catch (PDOException $error) {
    echo $error->getMessage();
}
