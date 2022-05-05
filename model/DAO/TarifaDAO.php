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

  function getArticulos(Tarifa $tarifa, array $campos)
  {
    //Si opero sobre el coste final
    if ($campos['coste'] == 0 || $campos['origen'] == 0) {
      /*
      *Creo una cadena con todas las condiciones que quiero para aplicarlas en la consulta
      *Las condiciones deben variar segun los filtros
      */
      if ($campos["marca"] == 0 && $campos['categoria'] == 0 && $campos['subcategoria'] == 0) {
        $articulos = $tarifa->getForeignValue('articulo');
      } else if ($campos["marca"] != 0 && $campos['categoria'] == 0 && $campos['subcategoria'] == 0) {
        $conditional = 'marca = ' . $campos["marca"];
        $articulos = $tarifa->getForeignValueString('articulo', $conditional);
      } else if ($campos["marca"] == 0 && $campos['categoria'] != 0 && $campos['subcategoria'] == 0) {
        $conditional = 'categoria = ' . $campos['categoria'];
        $articulos = $tarifa->getForeignValueString('articulo', $conditional);
      } else if ($campos["marca"] == 0 && $campos['categoria'] == 0 && $campos['subcategoria'] != 0) {
        $conditional = 'subcategoria = ' . $campos['subcategoria'];
        $articulos = $tarifa->getForeignValueString('articulo', $conditional);
      } else if ($campos["marca"] != 0 && $campos['categoria'] != 0 && $campos['subcategoria'] == 0) {
        $conditional = 'marca = ' . $campos["marca"] . ' AND categoria = ' . $campos['categoria'] . ' AND subcategoria = ' . $campos['subcategoria'];
        $articulos = $tarifa->getForeignValueString('articulo', $conditional);
      } else if ($campos["marca"] != 0 && $campos['categoria'] == 0 && $campos['subcategoria'] != 0) {
        $conditional = 'marca = ' . $campos["marca"] . ' AND subcategoria = ' . $campos['subcategoria'];
        $articulos = $tarifa->getForeignValueString('articulo', $conditional);
      } else if ($campos["marca"] == 0 && $campos['categoria'] != 0 && $campos['subcategoria'] != 0) {
        $conditional = 'categoria = ' . $campos['categoria'] . ' AND subcategoria = ' . $campos['subcategoria'];
        $articulos = $tarifa->getForeignValueString('articulo', $conditional);
      } else {
        $conditional = 'marca = ' . $campos["marca"] . ' AND categoria = ' . $campos['categoria'] . ' AND subcategoria = ' . $campos['subcategoria'];
        $articulos = $tarifa->getForeignValueString('articulo', $conditional);
      }
    } //Si actualizo una tarifa sobre otra
    else {
      if ($campos['coste'] == -1 || $campos['origen'] == -1) {
        $productos = $tarifa->getForeignValue('tarifasproductos');
        foreach ($productos as $fila => $campo) {
          $articulos[$fila]['coste'] = $campo['costeFinal'];
          $articulos[$fila]['idArticulo'] = $campo['idPrd'];
        }
      } else {
        $productos = $tarifa->getForeignValue('tarifasproductos', $campos['coste'], 'idTarifa');
        foreach ($productos as $fila => $campo) {
          $articulos[$fila]['coste'] = $campo['costeFinal'];
          $articulos[$fila]['idArticulo'] = $campo['idPrd'];
        }
      }
    }
    return $articulos;
  }

  function calculoCostes(array $campos, float $incremento, int $RA, Tarifa $tarifa, int $index)
  {

    $articulos = $this->getArticulos($tarifa, $campos);
    //Si escogí incrementar el precio
    if ($campos['opera'] == '1') {
      //Compruebo que lo incremento en un importe fijo
      if ($campos['opc'] == '0') {
        foreach ($articulos as $fila) {
          switch ($RA) {
            case 4:
            case 8:
              $resultado = round($fila['coste'] + $incremento, 0);
              break;
            case 5:
            case 9:
              $resultado = round($fila['coste'] + $incremento, 1, PHP_ROUND_HALF_UP);
              break;
            case 6:
              $resultado = round((float)($fila['coste']) + (float)$incremento, 1, PHP_ROUND_HALF_UP) - (float)0.01;
              break;
            case 7:
              $resultado = round($fila['coste'] + $incremento, 2, PHP_ROUND_HALF_UP) - 0.001;
              break;
            case 10:
              $resultado = round($fila['coste'] + $incremento, 1, PHP_ROUND_HALF_UP) - 0.05;
              break;
            case 11:
              $resultado = round($fila['coste'] + $incremento, 2, PHP_ROUND_HALF_UP) - 0.005;
              break;
          }
          if ($resultado < 0)
            $resultado = 0;
          $tarifa->foreignInsert('tarifasproductos', ['idPrd', 'idTarifa', 'costeFinal'], ["idProd" => $fila['idArticulo'], "idTarifa" => $index, "resultado" => $resultado]);
        }
        //Si incremento en un porcentaje
      } else {
        foreach ($articulos as $fila) {
          switch ($RA) {
            case 4:
            case 8:
              $resultado = round($fila['coste'] + ($fila['coste'] * $incremento / 100), 0);
              break;
            case 5:
            case 9:
              $resultado = round($fila['coste'] + ($fila['coste'] * $incremento / 100), 1, PHP_ROUND_HALF_UP);
              break;
            case 6:
              $resultado = round($fila['coste'] + ($fila['coste'] * $incremento / 100), 1, PHP_ROUND_HALF_UP) - 0.01;
              break;
            case 7:
              $resultado = round($fila['coste'] + ((float) ($fila['coste']) * $incremento / 100), 2, PHP_ROUND_HALF_UP) - 0.001;
              break;
            case 10:
              $resultado = round($fila['coste'] + ((float) ($fila['coste']) * $incremento / 100), 1, PHP_ROUND_HALF_UP) - 0.05;
              break;
            case 11:
              $resultado = round($fila['coste'] + ((float) ($fila['coste']) * $incremento / 100), 2, PHP_ROUND_HALF_UP) - 0.005;
              break;
          }
          if ($resultado < 0)
            $resultado = 0;
          $tarifa->foreignInsert('tarifasproductos', ['idPrd', 'idTarifa', 'costeFinal'], ["idProd" => $fila['idArticulo'], "idTarifa" => $index, "resultado" => $resultado]);
        }
      }
      //Si decremento en importe fijo
    } else {
      if ($campos['opc'] == '0') {
        foreach ($articulos as $fila) {
          switch ($RA) {
            case 4:
            case 8:
              $resultado = round($fila['coste'] - $incremento, 0);
              break;
            case 5:
            case 9:
              $resultado = round($fila['coste'] - $incremento, 1, PHP_ROUND_HALF_UP);
              break;
            case 6:
              $resultado = round(($fila['coste']) - $incremento, 1, PHP_ROUND_HALF_UP) - 0.01;
              break;
            case 7:
              $resultado = round($fila['coste'] - $incremento, 2, PHP_ROUND_HALF_UP) - 0.001;
              break;
            case 10:
              $resultado = round($fila['coste'] - $incremento, 1, PHP_ROUND_HALF_UP) - 0.05;
              break;
            case 11:
              $resultado = round($fila['coste'] - $incremento, 2, PHP_ROUND_HALF_UP) - 0.005;
              break;
          }
          if ($resultado < 0)
            $resultado = 0;
          $tarifa->foreignInsert('tarifasproductos', ['idPrd', 'idTarifa', 'costeFinal'], ["idProd" => $fila['idArticulo'], "idTarifa" => $index, "resultado" => $resultado]);
        }
        //Si decremento en porcentaje
      } else {
        foreach ($articulos as $fila) {
          switch ($RA) {
            case 4:
            case 8:
              $resultado = round($fila['coste'] - ($fila['coste'] * $incremento / 100), 0);
              break;
            case 5:
            case 9:
              $resultado = round($fila['coste'] - ($fila['coste'] * $incremento / 100), 1, PHP_ROUND_HALF_UP);
              break;
            case 6:
              $resultado = round($fila['coste'] - ($fila['coste'] * $incremento / 100), 1, PHP_ROUND_HALF_UP) - 0.01;
              break;
            case 7:
              $resultado = round($fila['coste'] - ((float) ($fila['coste']) * $incremento / 100), 2, PHP_ROUND_HALF_UP) - 0.001;
              break;
            case 10:
              $resultado = round($fila['coste'] - ((float) ($fila['coste']) * $incremento / 100), 1, PHP_ROUND_HALF_UP) - 0.05;
              break;
            case 11:
              $resultado = round($fila['coste'] - ((float) ($fila['coste']) * $incremento / 100), 2, PHP_ROUND_HALF_UP) - 0.005;
              break;
          }
          if ($resultado < 0)
            $resultado = 0;
          $tarifa->foreignInsert('tarifasproductos', ['idPrd', 'idTarifa', 'costeFinal'], ["idProd" => $fila['idArticulo'], "idTarifa" => $index, "resultado" => $resultado]);
        }
      }
    }
  }
}
