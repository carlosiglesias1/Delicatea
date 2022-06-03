<?php
interface DAO
{
    /**
     * Añade un registro a base de datos
     *
     * @param  mixed $valores
     * @return void
     */
    public function addElement(array $valores):void;
    
    /**
     * Obtiene la lista de valores de base de datos
     *
     * @return array
     */
    public function getList(): array;
    
    /**
     * Actualiza un registro en base de datos
     *
     * @param  mixed $id
     * @param  mixed $valores
     * @return void
     */
    public function update(int $id, array $valores): void;
        
    /**
     * Busca un registro en base de datos
     *
     * @param  mixed $id
     * @return void
     */
    public function searchRow(int $id);
        
    /**
     * Borra un registro de base de datos
     *
     * @param  mixed $id
     * @return void
     */
    public function delete(int $id);
        
    /**
     * Borra todos los registros de base de datos
     *
     * @return void
     */
    public function deleteAll();
}
