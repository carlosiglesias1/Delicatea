<?php
require_once $_SESSION['WORKING_PATH']."model/Classes/Objects.php";
class Subcategoria implements JsonSerializable
{
    private $idSubCategoria;
    private $nombre;
    private $descripcion;
    private $categoria;

    public function __construct(array $parametros)
    {
        foreach($parametros as $key=>$value){
            $this->{$key} = $value;
        }
    }

    public function jsonSerialize()
    {
        return [$this->idSubCategoria, $this->nombre, $this->descripcion, $this->categoria];
    }

    /**
     * Get the value of idSubCategoria
     */
    public function getIdSubCategoria()
    {
        return $this->idSubCategoria;
    }

    /**
     * Set the value of idSubCategoria
     *
     * @return  self
     */
    public function setIdSubCategoria($idSubCategoria)
    {
        $this->idSubCategoria = $idSubCategoria;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set the value of categoria
     *
     * @return  self
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }
}
