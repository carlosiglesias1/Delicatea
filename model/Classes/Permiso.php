<?php
class Permiso implements JsonSerializable{
    private int $idPermiso;
    private int $usuario;
    private int $permiso;

    public function __construct(array $parametros)
    {
        foreach ($parametros as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function jsonSerialize()
    {
        return array($this->idPermiso, $this->usuario, $this->permiso);
    }

    /**
     * Get the value of idPermiso
     */ 
    public function getIdPermiso()
    {
        return $this->idPermiso;
    }

    /**
     * Set the value of idPermiso
     *
     * @return  self
     */ 
    public function setIdPermiso($idPermiso)
    {
        $this->idPermiso = $idPermiso;

        return $this;
    }

    /**
     * Get the value of usuario
     */ 
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     *
     * @return  self
     */ 
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of permiso
     */ 
    public function getPermiso()
    {
        return $this->permiso;
    }

    /**
     * Set the value of permiso
     *
     * @return  self
     */ 
    public function setPermiso($permiso)
    {
        $this->permiso = $permiso;

        return $this;
    }
}   
?>