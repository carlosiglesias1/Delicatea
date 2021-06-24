<?php
include '../Delicatea/Lenguajes/es.php';
if (isset($_POST['submit'])) {

    $resultado = [
        'error' => false,
    ];

    $config = include '../../Conexion/config.php';

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        // Código que insertará un usuario
        $usuario = array(
            "nickname" => $_POST['nickname'],
            "contraseña" => $_POST['contraseña'],
            "RepContraseña" => $_POST['repContraseña']
        );
        if ($usuario["contraseña"] != $usuario["RepContraseña"]) {
            echo $lang["errorContraseña"];
        } else {
            $consultaSQL = "INSERT INTO users (nick, email) values(:" . implode(", :", array_keys($usuario)) . ")";
            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->execute($usuario);
            echo "Suu";
        }
    } catch (PDOException $error) {
        $resultado['error'] = true;
        echo $error->getMessage();
    }
}
?>
<?php
include '../../Vistas/Usuario/crear.php';
