<?php
class Marca implements JsonSerializable
{
    private int $idMarca;
    private string $nombre;

    public function __construct(array $parametros)
    {
        foreach ($parametros as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function jsonSerialize():array
    {
        return [$this->idMarca, $this->nombre];
    }

    /**
     * Get the value of idMarca
     */
    public function getIdMarca()
    {
        return $this->idMarca;
    }

    /**
     * Set the value of idMarca
     *
     * @return  self
     */
    public function setIdMarca($idMarca)
    {
        $this->idMarca = $idMarca;

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
}
