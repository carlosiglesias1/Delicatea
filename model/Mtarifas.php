<?php
require_once($_SESSION['WORKING_PATH'] . 'Back/Modelos/Mestandar.php');
class Tarifa extends Estandar
{

    public function __construct()
    {
        parent::__construct('tarifas');
    }

    public function newTarifa($formula)
    {
        $campos = ['nombre', 'formula', 'origen', 'precioManual', 'redondeo', 'ajuste', 'marca', 'categoria', 'subcategoria'];
        $valores = array(
            "nombre" => $_POST['nombre'],
            "formula" => $formula,
            "origen" => $_POST['coste'],
            "precioManual" => $_POST['precioManual'],
            "redondeo" => $_POST['redondeo'],
            "ajuste" => $_POST['ajuste'],
            'marca' => $_POST['marca'],
            'categoria' => $_POST['categoria'],
            'subcategoria' => $_POST['subcategoria']
        );
        $valor = $this->exists($valores['nombre']);
        if ($valor == 0) {
            try {
                //return parent::insert($campos, $valores)-1;
            } catch (PDOException $ex) {
                throw $ex;
            }
        }
    }

    public function updateTarifa(string $id, string $formula)
    {
        $campos = array(
            //"nombre" => $_POST['nombre'],
            "formula" => $formula
            /*"precioManual" => $_POST['precioManual'],
            "redondeo" => $_POST['redondeo'],
            "ajuste" => $_POST['ajuste'],
            'marca' => $_POST['marca'],
            'categoria' => $_POST['categoria'],
            'subcategoria' => $_POST['subcategoria']*/
        );
        $string = concatenar($campos);
        return parent::updateItem($string, 'idTarifa', $id);
    }

    public function getByID($id)
    {
        //return parent::getBy('idTarifa', $id);
    }

    public function getByName(string $name)
    {
        //return parent::getBy('nombre', "'" . $name . "'");
    }

    public function deleteByID($id)
    {
        //return parent::deleteBy('idTarifa', $id);
    }

    private function exists($tipo)
    {
        //return parent::existsBy('nombre', "'" . $tipo . "'");
    }
}
