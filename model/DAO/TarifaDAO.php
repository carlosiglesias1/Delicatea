<?php
require_once $_SESSION['WORKING_PATH'] . 'model/Mestandar.php';
require_once $_SESSION['WORKING_PATH'] . 'model/Classes/Tarifa.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/DAO.php';

class TarifaDAO extends Estandar implements DAO
{
  public function __construct(PDO $connection)
  {
    parent::__construct($connection, 'tarifas');
  }

  public function getList(): array
  {
    $tarifas = parent::getAll();
    $tarifasList = array();
    foreach ($tarifas as $key) {
      array_push($tarifasList, new TArifa($key));
    }
    return $tarifasList;
  }

  public function addElement(array $values): void
  {
    $formula = $this->calculaFormula([$values['opera'], $values['incremento'], $values['opc']]);
    $values = [
      "nombre" => $values['nombre'],
      "formula" => $formula,
      "origen" => $values['coste'],
      "precioManual" => $values['precioManual'],
      "redondeo" => $values['redondeo'],
      "ajuste" => $values['ajuste'],
      'marca' => $values['marca'],
      'categoria' => $values['categoria'],
      'subcategoria' => $values['subcategoria']
    ];
    $tipos = [
      PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_INT
    ];
    parent::insert(array_keys($values), $values, $tipos);
  }

  public function update(int $id, array $values): void
  {
    # code...
  }

  public function searchRow(int $id): Tarifa
  {
    return new Tarifa(parent::getBy('idTarifa', $id, PDO::PARAM_STR));
  }

  public function delete(int $id): void
  {
    # code...
  }

  private function calculaFormula(array $parametros): string
  {
    return $parametros[0] . $parametros[1] . $parametros[2];
  }
}
