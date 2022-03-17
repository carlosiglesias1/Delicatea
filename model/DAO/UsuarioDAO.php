<?php
require_once "DAO.php";
require_once($_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php');
require_once($_SESSION['WORKING_PATH'] . "Back/Modelos/Classes/Usuario.php");
class UsuarioDAO extends Estandar implements DAO
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection, 'usuarios');
    }

    public function addElement(array $valores): void
    {
        $campos = ["nick", "pass"];
        $valor = $this->exists($valores['nickname']);
        $tipos = [PDO::PARAM_STR, PDO::PARAM_STR];
        if ($valor == 0) {
            try {
                parent::insert($campos, $valores, $tipos);
                header("Location: BCcontrol.php?menu=1&lang=es");
            } catch (PDOException $exception) {
                echo $exception->getTrace();
            }
        } else {
            header("Location: " . $_SESSION['INDEX_PATH'] . "Back/Vistas/Usuario/BVUsuariofail.php");
        }
    }
    public function update(int $id, array $valores): void
    {
        $camposYTipos = [
            "nick" => PDO::PARAM_STR,
            "rol" => PDO::PARAM_INT
        ];
        foreach ($camposYTipos as $campo => $tipo) {
            parent::updateValue($campo, $valores[$campo], $tipo, "idUsr", $id);
        }
    }
    public function delete(int $id)
    {
        return parent::deleteBy("idUsr", $id, PDO::PARAM_INT);
    }
    public function getList(): array
    {
        $array = parent::getAll();
        $list = array_fill(0, sizeof($array), NULL);
        for ($i = 0; $i < sizeof($array); $i++) {
            $list[$i] = new Usuario($array[$i]);
        }
        return $list;
    }
    public function getPermissions($id)
    {
        return parent::getForeignValue('permisosmenu', null, $id, 'usuario');
    }
    public function searchRow(int $id)
    {
        return new Usuario(parent::getBy("idUsr", $id, PDO::PARAM_INT));
    }
    public function searchByName(string $value)
    {
        return new Usuario(parent::getBy("nick", $value, PDO::PARAM_STR));
    }
    private function exists($nickname)
    {
        return parent::existsBy('nick', $nickname, PDO::PARAM_STR);
    }
}
