<?php

namespace App\Repositories\Usuarios;

interface UsuarioRepositoryInterface {
    public function create(array $data);
    public function find($id);
    public function findAll();
    public function update($user, array $data);
    public function delete($userId);
}