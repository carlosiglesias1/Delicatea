<?php
require_once('../Modelos/Mestandar.php');
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
        if ($valor == 0) {
            parent::insert($campos, $valores);
            header("Location: BCcontrol.php?menu=1");
        } else {
            header("Location: ../Vistas/Usuario/BVUsuariofail.php");
        }
    }

    public function updateUser(string $id)
    {
        $campos = array(
            "nick" => $_POST['nickname'],
            "pass" => hash("sha512", $_POST['password'])
        );
        $string = concatenar($campos);
        return parent::update($string, 'idUsr', $id);
    }

    public function getByID($id){
        return parent::getBy('idUsr', $id);
    }

    public function deleteByID($id)
    {
        return parent::deleteBy('idUsr', $id);
    }

    private function exists($nickname)
    {
        return parent::existsBy('nick', "'" . $nickname . "'");
    }
    
}
