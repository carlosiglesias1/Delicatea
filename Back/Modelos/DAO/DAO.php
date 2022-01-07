<?php
interface DAO
{
    public function getList(): array;
    public function update(int $id, array $valores): void;
    public function delete(int $id);
    public function deleteAll();
}
