<?php
class Tarifa
{

  private int $idTarifa;
  private string $nombre;
  private string $formula;
  private string $origen;
  private float $precioManual;
  private float $redondeo;
  private float $ajuste;
  private Marca $marca;
  private Categoria $categoria;
  private Subcategoria $subcategoria;

  public function __construct(array $parametros)
  {
    foreach ($parametros as $key => $value) {
      $this->{$key} = $value;
    }
  }
  /**
   * Get the value of idTarifa
   */
  public function getIdTarifa()
  {
    return $this->idTarifa;
  }

  /**
   * Set the value of idTarifa
   *
   * @return  self
   */
  public function setIdTarifa($idTarifa)
  {
    $this->idTarifa = $idTarifa;

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
   * Get the value of formula
   */
  public function getFormula()
  {
    return $this->formula;
  }

  /**
   * Set the value of formula
   *
   * @return  self
   */
  public function setFormula($formula)
  {
    $this->formula = $formula;

    return $this;
  }

  /**
   * Get the value of origen
   */
  public function getOrigen()
  {
    return $this->origen;
  }

  /**
   * Set the value of origen
   *
   * @return  self
   */
  public function setOrigen($origen)
  {
    $this->origen = $origen;

    return $this;
  }

  /**
   * Get the value of precioManual
   */
  public function getPrecioManual()
  {
    return $this->precioManual;
  }

  /**
   * Set the value of precioManual
   *
   * @return  self
   */
  public function setPrecioManual($precioManual)
  {
    $this->precioManual = $precioManual;

    return $this;
  }

  /**
   * Get the value of redondeo
   */
  public function getRedondeo()
  {
    return $this->redondeo;
  }

  /**
   * Set the value of redondeo
   *
   * @return  self
   */
  public function setRedondeo($redondeo)
  {
    $this->redondeo = $redondeo;

    return $this;
  }

  /**
   * Get the value of ajuste
   */
  public function getAjuste()
  {
    return $this->ajuste;
  }

  /**
   * Set the value of ajuste
   *
   * @return  self
   */
  public function setAjuste($ajuste)
  {
    $this->ajuste = $ajuste;

    return $this;
  }

  /**
   * Get the value of marca
   */
  public function getMarca()
  {
    return $this->marca;
  }

  /**
   * Set the value of marca
   *
   * @return  self
   */
  public function setMarca($marca)
  {
    $this->marca = $marca;

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

  /**
   * Get the value of subcategoria
   */
  public function getSubcategoria()
  {
    return $this->subcategoria;
  }

  /**
   * Set the value of subcategoria
   *
   * @return  self
   */
  public function setSubcategoria($subcategoria)
  {
    $this->subcategoria = $subcategoria;

    return $this;
  }
}
