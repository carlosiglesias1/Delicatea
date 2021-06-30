<?php
require('../Modelos/Mestandar.php');
class Usuarios extends Estandar
{

    public function __construct($tabla)
    {
        parent::__construct($tabla);
    }

    public function newUser()
    {
        $campos = ['nick', 'pass'];
        $valores = array(
            "nickname" => $_POST['nickname'],
            "password" => hash("sha512", $_POST['password'])
        );
        $valor = $this->exists($valores['nickname']);
        //if (count($valor) == 0) {
            parent::insert($campos, $valores);
            //header("Location: ../Vistas/Usuario/BVUsuariook.php");
        //} else {
            //header("Location: ../Vistas/Usuario/BVUsuariofallo.php");
        //}
        
    }

    private function exists($nickname)
    {
        $db = parent::getDB();
        $sentencia = $db->prepare("SELECT * FROM usuarios WHERE nick = '$nickname'");
        $resultado = $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
        echo $resultado;
        return $resultado;
    }
}
