<?php
require_once "DAO.php";
require_once($_SESSION['WORKING_PATH'] . 'model/Mestandar.php');
require_once($_SESSION['WORKING_PATH'] . "model/Classes/Usuario.php");
class UsuarioDAO extends Estandar implements DAO
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection, 'usuarios');
    }

    public function get()
    {
        return new Usuario();
    }

    public function addElement(array $valores): void
    {
        $campos = ["nick", "pass"];
        $valor = $this->exists($valores['nick']);
        $tipos = [PDO::PARAM_STR, PDO::PARAM_STR];
        if ($valor == 0) {
            try {
                parent::insert($campos, $valores, $tipos);
            } catch (PDOException $exception) {
                print_r($exception->getTrace());
            }
        }
    }
    public function update(int $id, array $valores): void
    {
        $camposYTipos = [
            "nick" => PDO::PARAM_STR,
            "pass" => PDO::PARAM_STR,
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
    public function getPermissions(int $id)
    {
        return parent::getForeignValue('permisosmenu', null, $id, 'usuario');
    }
    public function searchRow(int $id)
    {
        return new Usuario(parent::getBy("idUsr", $id, PDO::PARAM_INT));
    }
    public function searchByName(string $value): Usuario
    {
        try {
            return new Usuario(parent::getBy("nick", $value, PDO::PARAM_STR));
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function logIn(Usuario $user): bool
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $exists = $this->searchByName($user->getNick());
        if ($exists != null && $exists->getPass() == $user->getPass()) {
            session_start();
            $_SESSION['id'] = $exists->getIdUsr();
            $_SESSION['lang'] = $_GET['lang'];
            return true;
        }
        return false;
    }

    public function mobileLogIn(Usuario $user):bool
    {
        $exists = $this->searchByName($user->getNick());
        if ($exists != null && $exists->getPass() == $user->getPass()) {
            $_SESSION['id'] = $exists->getIdUsr();
            $_SESSION['lang'] = $_GET['lang'];
            return true;
        }
        return false;
    }

    private function exists($nickname)
    {
        return parent::existsBy('nick', $nickname, PDO::PARAM_STR);
    }
}
