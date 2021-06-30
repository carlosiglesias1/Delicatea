<?php
include '../../Lenguajes/es.php';
//include '../../Conexion/Conectar.php';
if (isset($_POST['submit'])) {

    $resultado = [
        'error' => false,
    ];

    //$dbconfig = new Conectar;
    require_once '../../Conexion/Conectar.php';
    $conexion = new Conectar;
    $conexion = $conexion->conectar();

    try {
        // Código que insertará un usuario
        if ($_POST['password'] != $_POST['repPassword']) {
            echo $lang["errorPassword"];
        } else {
            $usuario = array(
                "nickname" => $_POST['nickname'],
                "password" => hash("sha512", $_POST['password'])
            );
            $campos = ['nick', 'pass'];
            echo implode(", ",$campos);
            $cSQL = "INSERT INTO usuarios (". implode(", ", $campos) . ") values(:" . implode(", :", array_keys($usuario)) . ")";
            //$cSQL = "INSERT INTO usuarios (nick, pass) values(:" . implode(", :", array_keys($usuario)) . ")";
            //$cSQL = "INSERT INTO $tabla (:" . implode(", :", array_keys($campos)) . ") values(:" . implode(", :", array_keys($usuario)) . ")";      
            $sentencia = $conexion->prepare($cSQL);
            $sentencia->execute($usuario);
            echo "Suu";
        }
    } catch (PDOException $error) {
        $resultado['error'] = true;
        echo $error->getMessage();
    }
}
