<?php 

namespace App\Repositories\Usuarios;

use App\Models\User;
use App\Repositories\Usuarios\UsuarioRepositoryInterface;

class UsuarioRepository implements UsuarioRepositoryInterface {
    public function create(array $data)
    {
        return User::create($data);
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function findAll()
    {
        return User::paginate(10);
    }

    public function update($user, array $data)
    {
        return $user->update($data);
    }

    public function delete($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }
}
