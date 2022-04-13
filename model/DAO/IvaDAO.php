<?php
require_once($_SESSION['WORKING_PATH'] . 'model/Mestandar.php');
require_once($_SESSION['WORKING_PATH'] . 'model/DAO/DAO.php');
require_once($_SESSION['WORKING_PATH'] . 'model/Classes/IVA.php');

class IvaDAO extends Estandar implements DAO
{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn, 'tiposiva');
    }

    public function addElement(array $valores): void
    {
        $tipos = [
            PDO::PARAM_STR,
            PDO::PARAM_INT
        ];
        $campos = ['tipo', 'porcentage'];
        $valor = $this->exists($valores['tipo']);
        if ($valor == 0) {
            parent::insert($campos, $valores, $tipos);
        }
    }

    public function getList(): array
    {
        $array = parent::getAll();
        $list = array_fill(0, sizeof($array), NULL);
        for ($i = 0; $i < sizeof($array); $i++) {
            $list[$i] = new IVA($array[$i]);
        }
        return $list;
    }

    public function update(int $id, array $valores): void
    {

        $camposYTipos = [
            "tipo" => PDO::PARAM_STR,
            "porcentage" => PDO::PARAM_STR
        ];
        foreach ($camposYTipos as $campo => $tipo) {
            parent::updateValue($campo, $valores[$campo], $tipo, "idIva", $id);
        }
    }

    public function delete(int $id)
    {
        parent::deleteBy('idIva', $id, PDO::PARAM_INT);
    }

    public function searchRow(int $id): IVA
    {
        return new IVA(parent::getBy('idIva', $id, PDO::PARAM_STR));
    }
    private function exists(string $valor): bool
    {
        return parent::existsBy('tipo', $valor, PDO::PARAM_STR);
    }
}
