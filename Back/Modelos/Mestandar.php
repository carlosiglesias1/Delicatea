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
            $sentencia->setFetchMode(PDO::FETCH_ASSOC);
            $sentencia->execute();
            return $sentencia->fetchAll();
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            throw $ex;
        }
    }

    public function getBy(string $campo, $valor, int $tipo)
    {
        $query = "SELECT * FROM $this->table WHERE $campo = :valor";
        try {
            $sentencia = $this->bd->prepare($query);
            $sentencia->bindParam(":valor", $valor, $tipo);
            $sentencia->execute();
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param string $foreignTable la tabla de la que vamos a obtener el valor
     * @param string $foreignValue el valor que queremos obtener
     * @param string $value valor que tenemos en la tabla de origen
     * @param string $foreignKey campo de union en la tabla destino
     * @param string $orderBy nombre del campo por el que vamos a ordenar
     * @return array
     */
    public function getForeignValue(string $foreignTable, ?string $foreignValue = null, ?string $value = null, ?string $foreignKey = null, ?string $orderBy = null)
    {
        if ($orderBy == null) {
            if ($foreignValue == null && $foreignKey == null) {
                $query = "SELECT * FROM $foreignTable";
            } else if ($foreignValue == null) {
                $query = "SELECT * FROM $foreignTable WHERE $foreignKey = $value";
            } else {
                $query = "SELECT $foreignValue FROM $foreignTable WHERE $foreignKey = $value ";
            }
        } else {
            if ($foreignValue == null && $foreignKey == null) {
                $query = "SELECT * FROM $foreignTable ORDER BY $orderBy";
            } else if ($foreignValue == null) {
                $query = "SELECT * FROM $foreignTable WHERE $foreignKey = $value ORDER BY $orderBy";
            } else {
                $query = "SELECT $foreignValue FROM $foreignTable WHERE $foreignKey = $value ORDER BY $orderBy";
            }
        }
        $this->bd->beginTransaction();
        $sentencia = $this->bd->prepare($query);
        $sentencia->execute();
        try {
            $this->bd->commit();
            return $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            $this->bd->rollBack();
            error_log($error->getMessage());
            return array();
        }
    }

    public function getForeignValueString(string $foreignTable, string $conditional, string $foreignValue = null, string $orderBy = null)
    {
        if ($orderBy == null) {
            if ($foreignValue == null && $conditional == null) {
                $query = "SELECT * FROM $foreignTable";
            } else if ($foreignValue == null) {
                $query = "SELECT * FROM $foreignTable WHERE $conditional";
            } else {
                $query = "SELECT $foreignValue FROM $foreignTable WHERE $conditional";
            }
        } else {
            if ($foreignValue == null && $conditional == null) {
                $query = "SELECT * FROM $foreignTable ORDER BY $orderBy";
            } else if ($foreignValue == null) {
                $query = "SELECT * FROM $foreignTable WHERE $conditional ORDER BY $orderBy";
            } else {
                $query = "SELECT $foreignValue FROM $foreignTable WHERE $conditional ORDER BY $orderBy";
            }
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
            error_log($exception->getMessage());
            throw $exception;
        }
    }

    public function insert(array $campos, array $valores, array $tipos)
    {
        //aqui realizo un Prepared Statement de php
        $query = "INSERT INTO $this->table (" . implode(",", $campos) . ") VALUES (:" . implode(", :", array_keys($valores)) . ")";
        try {
            $this->bd->beginTransaction();
            $sentencia = $this->bd->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
            $queryParams = array_keys($valores);
            $valores = array_values($valores);
            for ($index = 0; $index < sizeof($campos); $index++) {
                $sentencia->bindParam(":" . $queryParams[$index], $valores[$index], $tipos[$index]);
            }
            $sentencia->execute();
            try {
                $this->bd->commit();
                return $this->getAutoIncrement()->fetchAll(PDO::FETCH_ASSOC)[0]['AUTO_INCREMENT'];
            } catch (PDOException $error) {
                $this->bd->rollBack();
                throw $error;
            }
        } catch (PDOException $excpt) {
            error_log($excpt->getMessage());
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
            error_log($excpt->getMessage());
            throw $excpt;
        }
    }

    public function deleteBy($campo, $value, int $type)
    {
        $query = "DELETE FROM $this->table 
                        WHERE $campo = :valor";
        echo $query . "</br>";
        echo $campo;
        echo $value . " " . $type . "</br>";
        try {
            $this->bd->beginTransaction();
            $sentencia = $this->bd->prepare($query);
            $sentencia->bindParam(":valor", $value, $type);
            if ($sentencia->execute()) {
                try {
                    $this->bd->commit();
                } catch (PDOException $error) {
                    $this->bd->rollBack();
                    throw $error;
                }
                return $sentencia->rowCount();
            } else {
                return -1;
            }
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
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
            error_log($ex->getMessage());
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
            error_log($ex->getMessage());
            throw $ex;
        }
        try {
            $sentencia = $this->bd->prepare($query2);
            $sentencia->execute();
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            throw $ex;
        }
    }
    /**
     * @param string $campo       nombre del campo a cambiar
     * @param mixed $nuevoValor   nuevo valor del campo
     * @param int $tipo            tipo de dato para validar
     * @param string $identificador nombre del campo por el que voy a buscar el elemento que voy a actualizar
     * @param int $valor         valor del identificador
     * @return void
     */
    public function updateValue(string $campo, mixed $nuevoValor, int $tipo, string $identificador, int $valor)
    {
        $query = "UPDATE $this->table SET $campo = :valor WHERE $identificador = :id";
        try {
            $this->bd->beginTransaction();
            $sentencia = $this->bd->prepare($query);
            $sentencia->bindParam(":valor", $nuevoValor, $tipo);
            $sentencia->bindParam(":id", $valor, PDO::PARAM_INT);
            if ($sentencia->execute()) {
                $this->bd->commit();
            } else {
                $this->bd->rollBack();
            }
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            throw ($ex);
        }
    }

    public function updateItem(string $cadena, string $campo,  string $valor)
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
            error_log($excpt->getMessage());
            throw $excpt;
        }
    }

    public function existsBy($campo, $valor, $tipo)
    {
        try {
            $sentencia = $this->bd->prepare("SELECT * FROM " . $this->getTable() . " WHERE $campo = :valor");
            $sentencia->bindParam(":valor", $valor, $tipo);
            $sentencia->execute();
            return $sentencia->rowCount();
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
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
            error_log($error->getMessage());
            throw $error;
        }
    }
}
