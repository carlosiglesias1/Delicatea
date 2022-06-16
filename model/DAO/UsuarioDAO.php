<?php
require_once "DAO.php";
require_once($_SESSION['WORKING_PATH'] . 'model/Mestandar.php');
require_once($_SESSION['WORKING_PATH'] . "model/Classes/Usuario.php");
class UsuarioDAO extends Estandar implements DAO
{
    /**
     * @param PDO connection 
     */
    public function __construct(PDO $connection)
    {
        parent::__construct($connection, 'usuarios');
    }

    /**
     * Devuelve un nuevo usuario
     *
     * @return Usuario
     */
    public function get(): Usuario
    {
        return new Usuario();
    }

    /**
     * Añade un nuevo Usuario a base de datos
     *
     * @param  mixed $valores
     * @return void
     */
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

    /**
     * Actualiza un usuario en Base de datos
     *
     * @param  mixed $id
     * @param  mixed $valores
     * @return void
     */
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

    /**
     * Borra un usuario de base de datos
     *
     * @param  mixed $id
     * @return void
     */
    public function delete(int $id)
    {
        if (parent::deleteBy("idUsr", $id, PDO::PARAM_INT) == 1) {
            parent::foreignDelete('permisosmenu', 'usuario', $id);
        }
    }

    /**
     * Obtiene la lista de todos los usuarios de la base de datos
     *
     * @return array
     */
    public function getList(): array
    {
        $array = parent::getAll();
        $list = array_fill(0, sizeof($array), NULL);
        for ($i = 0; $i < sizeof($array); $i++) {
            $list[$i] = new Usuario($array[$i]);
        }
        return $list;
    }

    /**
     * Obtiene los permisos de los usuarios
     *
     * @param  mixed $id
     * @return array
     */
    public function getPermissions(int $id): array
    {
        return parent::getForeignValue('permisosmenu', null, $id, 'usuario');
    }

    /**
     * Busca un registro
     *
     * @param  mixed $id
     * @return void
     * @see DAO::searchRow()
     */
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

    public function mobileLogIn(Usuario $user): bool
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
