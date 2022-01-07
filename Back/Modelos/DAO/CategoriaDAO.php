<?php
class CategoriaDAO extends Estandar implements DAO
{


    public function getList():array
    {
        $matrix = parent::getAll();
        $lista = array_fill(0, sizeof($matrix), 0);
        for ($i = 0; $i < sizeof($lista); $i++) {
            $lista[$i] = new Categoria($matrix[$i]);
        }
        return $lista;
    }

    public function update(int $id, array $valores):void
    {
        $camposYTipos = [
            "nombre" => PDO::PARAM_STR,
            "descripcion" => PDO::PARAM_STR
        ];
        foreach ($camposYTipos as $campo => $tipo) {
            parent::updateValue($campo, $valores[$campo], $tipo, "idUsr", $id);
        }
    }
    public function delete(int $id)
    {
        parent::deleteBy('idCategoria', $id, PDO::PARAM_INT);
    }
}
