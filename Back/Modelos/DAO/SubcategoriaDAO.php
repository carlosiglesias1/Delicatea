<?php
require_once $_SESSION['WORKING_PATH'].'Back/Modelos/Mestandar.php';
    class SubcategoriaDAO extends Estandar implements DAO{
        public function getList(): array
        {
            $array = parent::getAll();
        }
        public function searchRow(int $id)
        {
            
        }
        public function update(int $id, array $valores): void
        {
            
        }
        public function delete(int $id)
        {
            
        }
        public function deleteAll()
        {
            
        }
    }