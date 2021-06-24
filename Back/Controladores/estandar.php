<?php
class Estandar
{
    private $table;
    private $bd;

    public function __construct($tabla)
    {
        $this->table = $tabla;
        require_once '../../Conexion/Conectar.php';
        $this->bd = new Conectar;
        $this->bd = $this->bd->conectar();
    }

    public function getDB()
    {
        return $this->bd;
    }

    public function insert($dim)
    {

        for ($i = 0; $i < $dim; $i++) {
        }
    }

    public function deleteID($id)
    {
        $query = "DELETE FROM $this->table WHERE ID = '$id'";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute($this->table, $id);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function deleteAll()
    {
        $query = "DELETE FROM $this->table";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute($this->table);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
