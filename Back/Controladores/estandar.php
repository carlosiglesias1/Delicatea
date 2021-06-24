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

    public function insert($campos, $valores)
    {
        $query =  "INSERT INTO $this->table (:" . implode(", :", array_keys($campos)) . ") values(:" . implode(", :", array_keys($valores)) . ")";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute($this->table);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function deleteByID($id)
    {
        $query = "DELETE FROM $this->table WHERE ID = '$id'";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute($this->table, $id);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function deleteBy ($campo, $value){
        $query = "DELETE FROM $this->table WHERE $campo = $value";
    }

    public function deleteAll()
    {
        $query = "DELETE FROM $this->table";
        $query2 = "ALTER TABLE $this->table AUTO_INCREMENT = 1";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute($this->table);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        try {
            $sentencia = $this->bd->prepare($query2);
            $sentencia->execute($this->table);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
