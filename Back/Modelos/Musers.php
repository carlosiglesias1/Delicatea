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
        if ($valor == 0) {
            parent::insert($campos, $valores);
            header("Location: BCcontrol.php?menu=1");
        } else {
            header("Location: ../Vistas/Usuario/BVUsuariofail.php");
        }
    }

    /*public function update()
    {
        
    }*/

    public function getByID($id){
        return parent::getBy('idUsr', $id);
    }

    private function exists($nickname)
    {
        return parent::existsBy('nick', "'" . $nickname . "'");
    }

    public function deleteByID($id)
    {
        return parent::deleteBy('idUsr', $id);
    }
}
