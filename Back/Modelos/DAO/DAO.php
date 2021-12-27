<?php
interface DAO{
    public function getList();
    public function update(int $id, array $valores);
    public function delete(int $id);
    public function deleteAll();
}