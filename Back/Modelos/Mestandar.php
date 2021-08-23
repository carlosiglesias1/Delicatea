<?php
abstract class Estandar
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

    public function getBy(string $campo, $valor)
    {
        $query = "SELECT * FROM $this->table WHERE $campo = $valor";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute();
            return $sentencia;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getForeignValue(?string $foreignValue = null, string $foreignTable, ?string $value = null, ?string $foreignKey = null, ?string $orderBy = null)
    {
        /**
         * $foreignValue => el valor que queremos obtener
         * $foreignTable => la tabla de la que vamos a obtener el valor
         * $value => valor que tenemos en la tabla de origen
         * $foreignKey => campo de union en la tabla destino
         */
        if ($orderBy == null) {
            if ($foreignValue == null && $foreignKey == null) {
                $query = "SELECT * FROM $foreignTable";
            } else if ($foreignValue == null) {
                $query = "SELECT * FROM $foreignTable WHERE $foreignKey = $value";
            } else
                $query = "SELECT $foreignValue FROM $foreignTable WHERE $foreignKey = $value ";
        } else {
            if ($foreignValue == null && $foreignKey == null) {
                $query = "SELECT * FROM $foreignTable ORDER BY $orderBy";
            } else if ($foreignValue == null) {
                $query = "SELECT * FROM $foreignTable WHERE $foreignKey = $value ORDER BY $orderBy";
            } else
                $query = "SELECT $foreignValue FROM $foreignTable WHERE $foreignKey = $value ORDER BY $orderBy";
        }
        try {
            $this->bd->beginTransaction();
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute();
            try {
                $this->bd->commit();
                return $sentencia;
            } catch (PDOException $error) {
                $this->bd->rollBack();
                throw $error;
            }
        } catch (PDOException $exception) {
            throw $exception;
        }
    }

    public function getForeignValueString(string $foreignValue = null, string $foreignTable, string $conditional, string $orderBy = null)
    {
        if ($orderBy == null) {
            if ($foreignValue == null && $conditional == null) {
                $query = "SELECT * FROM $foreignTable";
            } else if ($foreignValue == null) {
                $query = "SELECT * FROM $foreignTable WHERE $conditional";
            } else
                $query = "SELECT $foreignValue FROM $foreignTable WHERE $conditional";
        } else {
            if ($foreignValue == null && $conditional == null) {
                $query = "SELECT * FROM $foreignTable ORDER BY $orderBy";
            } else if ($foreignValue == null) {
                $query = "SELECT * FROM $foreignTable WHERE $conditional ORDER BY $orderBy";
            } else
                $query = "SELECT $foreignValue FROM $foreignTable WHERE $conditional ORDER BY $orderBy";
        }
        try {
            $this->bd->beginTransaction();
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute();
            try {
                $this->bd->commit();
                return $sentencia;
            } catch (PDOException $error) {
                $this->bd->rollBack();
                throw $error;
            }
        } catch (PDOException $exception) {
            throw $exception;
        }
    }

    public function insert($campos, $valores, $return = null)
    {
        $query = "INSERT INTO $this->table (" . implode(", ", $campos) . ") values(:" . implode(", :", array_keys($valores)) . ")";
        try {
            $this->bd->beginTransaction();
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute($valores);
            try {
                $this->bd->commit();
                return $this->getAutoIncrement()->fetchAll(PDO::FETCH_ASSOC)[0]['AUTO_INCREMENT'];
            } catch (PDOException $error) {
                $this->bd->rollBack();
                throw $error;
            }
        } catch (PDOException $excpt) {
            throw $excpt;
        }
    }

    public function foreignInsert($table, $campos, $valores)
    {
        $query = "INSERT INTO $table (" . implode(", ", $campos) . ") values(:" . implode(", :", array_keys($valores)) . ")";
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

    public function deleteBy($campo, $value)
    {
        $query = "DELETE FROM $this->table WHERE $campo = $value";
        try {
            $this->bd->beginTransaction();
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute();
            try {
                $this->bd->commit();
            } catch (PDOException $error) {
                $this->bd->rollBack();
                throw $error;
            }
            return $sentencia->rowCount();
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    public function foreignDelete(string $table, string $campo, mixed $value)
    {
        $query = "DELETE FROM $table WHERE $campo = $value";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute();
            return $sentencia->rowCount();
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    public function deleteAll()
    {
        $query = "DELETE FROM $this->table";
        $query2 = "ALTER TABLE $this->table AUTO_INCREMENT = 1";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute();
        } catch (PDOException $ex) {
            throw $ex;
        }
        try {
            $sentencia = $this->bd->prepare($query2);
            $sentencia->execute();
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    public function update(string $cadena, string $campo,  string $valor)
    {
        /**
         * La cadena incluirá todos los campos y los valores
         * de la tabla, para que el update se complete con éxito:
         * Para ello, en cada update especifico, hay que concatenar
         * todos los campos de las tablas con los valores que introduzca
         * el usuario.
         */
        $query = "UPDATE $this->table SET $cadena WHERE $campo = $valor";
        try {
            $this->bd->beginTransaction();
            $sentencia = $this->bd->prepare($query);
            $sentencia->execute();
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

    public function existsBy($campo, $valor)
    {
        try {
            $sentencia = $this->bd->prepare("SELECT * FROM " . $this->getTable() . " WHERE $campo = $valor");
            $sentencia->execute();
            return $sentencia->rowCount();
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    private function getAutoIncrement()
    {
        try {
            $this->bd->beginTransaction();
            $sentencia = $this->bd->prepare("SELECT AUTO_INCREMENT from information_schema.tables where table_schema = 'delicatea' AND table_name = '" . $this->getTable() . "'");
            $sentencia->execute();
            $this->bd->commit();
            return $sentencia;
        } catch (PDOException $error) {
            throw $error;
        }
    }
}
