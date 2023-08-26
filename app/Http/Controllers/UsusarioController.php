<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UsusarioController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users, 200);
        } catch (Exception $e) {
            return response()->json("Error: server error" . $e->getMessage(), 500);
        }
        
    }

    public function store(Request $request)
    {
        try {       
            $this->validate($request, [
                'nome' => 'required',
                'email' => 'required|email|unique:users',
            ]);

            $user = User::create($request->all());
            return response()->json($user, 200);
        } catch (Exception $e) {
            return response()->json("Error: server error" . $e->getMessage(), 500);
        }
    }

    public function update(Request $request, $userId)
    {
        try {
            $user = User::find($userId);

            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);

            if($user->update($request->all())){
                return response()->json('Usuário atualizado com sucesso.', 200);
            }
        } catch (Exception $e) {
            return response()->json("Error: server error" . $e->getMessage(), 500);
        }        
    }

    public function destroy($userId)
    {
        try {
            $user = User::find($userId);
            if($user) {
                $user->delete();
                return response()->json('Usuário excluído com sucesso.', 200);
            }
            return response()->json('Usuário não encontrado.', 404);
        } catch (Exception $e) {
            return response()->json("Error: server error" . $e->getMessage(), 500);
        }
    }
}
