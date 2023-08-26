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
            return response()->json(['Error' => $e->getMessage()], 500);
        }
        
    }

    public function show($id)
    {
        try {
            $users = User::find($id);
            return response()->json($users, 200);
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
        
    }

    public function store(Request $request)
    {
        try {       
            
            $this->validate($request, [
                'nome' => 'required',
                'sobrenome'=> '',
                'telefone'=> '',
                'email'=> '',
                'password'=> 'required'
            ]);

            $user = User::create($request->all());
            return response()->json($user, 200);
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, User $user)
    {

        try {
            $this->validate($request, [
                'nome' => '',
                'sobrenome'=> '',
                'telefone'=> '',
                'email'=> '',
                'password'=> '',
            ]);
            
            if($user->update($request->all())){
                return response()->json(['message' => 'Usuário atualizado com sucesso.', 'data' => $user], 200);
            }
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }        
    }

    public function destroy($userId)
    {
        try {
            $user = User::find($userId);
            if($user) {
                $user->delete();
                return response()->json(['message' => 'Usuário excluído com sucesso.'], 200);
            }
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }
}
