<?php
require_once $_SESSION['WORKING_PATH'] . 'model/Mestandar.php';
require_once $_SESSION['WORKING_PATH'] . 'model/Classes/Tarifa.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/DAO.php';
require_once $_SESSION['WORKING_PATH'] . 'model/DAO/factory/MySQLDAOFactory.php';

class TarifaDAO extends Estandar implements DAO
{
  private $factory;
  private $marcaDAO;
  private $categoriaDAO;
  private $subcategoriaDAO;
  public function __construct(PDO $connection)
  {
    parent::__construct($connection, 'tarifas');
    $this->factory = new MySQLDAOFactory();
    $this->marcaDAO = $this->factory->getMarcaDAO();
    $this->categoriaDAO = $this->factory->getCategoriaDAO();
    $this->subcategoriaDAO = $this->factory->getSubcategoriaDAO();
  }

  public function getList(): array
  {
    $tarifas = parent::getAll();
    $tarifasList = array();
    foreach ($tarifas as $key) {
      array_push($tarifasList, $this->instanciarTarifa($key));
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
    return $this->instanciarTarifa(parent::getBy('idTarifa', $id, PDO::PARAM_STR));
  }

  public function delete(int $id): void
  {
    # code...
  }

  private function instanciarTarifa(array $values): Tarifa
  {
    return new Tarifa([
      "nombre" => $values['nombre'],
      'formula' => $values['formula'],
      'origen' => $values['origen'],
      'precioManual' => $values['precioManual'],
      'redondeo' => $values['redondeo'],
      'ajuste' => $values['ajuste'],
      'marca' => $this->marcaDAO->searchRow($values['marca']),
      'categoria' => $this->categoriaDAO->searchRow($values['categoria']),
      'subcategoria' => $this->subcategoriaDAO->searchRow($values['subcategoria'])
    ]);
  }

  private function calculaFormula(array $parametros): string
  {
    return $parametros[0] . $parametros[1] . $parametros[2];
  }
  private function guardarArticulosTarifa(): void
  {
  }
}
