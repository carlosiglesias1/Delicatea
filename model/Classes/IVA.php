<?php
require_once($_SESSION['WORKING_PATH'] . 'model/Mestandar.php');
require_once($_SESSION['WORKING_PATH'] . 'model/Classes/Objects.php');
class IVA extends Estandar implements Objects
{
    private int $idIva;
    private string $tipo;
    private string $porcentage;

    public function __construct(array $parametros)
    {
        foreach ($parametros as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Get the value of tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of idIva
     */
    public function getIdIva()
    {
        return $this->idIva;
    }

    /**
     * Set the value of idIva
     *
     * @return  self
     */
    public function setIdIva($idIva)
    {
        $this->idIva = $idIva;

        return $this;
    }
    /**
     * Get the value of porcentage
     */
    public function getPorcentage()
    {
        return $this->porcentage;
    }

    /**
     * Set the value of porcentage
     *
     * @return  self
     */
    public function setPorcentage($porcentage)
    {
        $this->porcentage = $porcentage;

        return $this;
    }
}
