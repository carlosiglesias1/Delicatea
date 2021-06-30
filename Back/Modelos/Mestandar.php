<?php
class Estandar
{
    private $table;
    private $bd;

    public function __construct(string $tabla)
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

    public function getTable()
    {
        return $this->table;
    }

    public function getAll()
    {
        $query = "SELECT * FROM $this->table";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute();
            return $sentencia;
        } catch (PDOException $ex) {
            throw $ex->getMessage();
        }
    }

    public function insert($campos, $valores)
    {
        $query = "INSERT INTO $this->table (" . implode(", ", $campos) . ") values(:" . implode(", :", array_keys($valores)) . ")";
        try {
            $this->bd->beginTransaction();
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute($valores);
            try {
                $this->bd->commit();
            } catch (PDOException $error) {
                $this->bd->rollBack();
                throw $error;
            }
        } catch (PDOException $excpt) {
            throw $excpt;
        }
    }

    public function deleteByID($id)
    {
        $query = "DELETE FROM $this->table WHERE ID = '$id'";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute($this->table, $id);
        } catch (PDOException $ex) {
            throw $ex->getMessage();
        }
        return $sentencia;
    }

    public function deleteBy($campo, $value)
    {
        $query = "DELETE FROM $this->table WHERE $campo = $value";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute($this->table);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
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
