<?php

namespace App\Interface;

interface PostRepositoryInterface
{
    public function getAll(array $with = []);
    public function getById($id, array $with = []);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
