<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Services\Usuario\UsuarioService;
use Illuminate\Support\Facades\Validator;

class UsusarioController extends Controller
{

    private $usuarioService;

    public function __construct(UsuarioService $usuarioService){
        $this->usuarioService = $usuarioService;
    }

    public function index()
    {
        try {
            $users = $this->usuarioService->buscarTodosUsuarios();

            if($users)
                return response()->json($users, 200);

            return response()->json(['Message' => 'Nenhum encontrado'], 404);

        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->usuarioService->buscarUsuario($id);
            
            if($user)
                return response()->json($user, 200);

            return response()->json(['Message' => 'Usuário não encontrado'], 404);
            
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {        
        try {

            $validator = Validator::make($request->all(), [
                'nome' => 'required',
                'sobrenome' => '',
                'telefone' => '',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'confirm_password' => 'required',
            ]);

            if($request->password != $request->confirm_password)
                return response()->json(['Error' => 'As senhas recebidas em password e confirm_password, não conferem.' ], 400);
            
            if ($validator->fails()) {
                return response()->json(['Error' => $validator->errors()], 400);
            }

            $usuario = $this->usuarioService->criarUsuario($request->all());

            if($usuario)
                return response()->json($usuario, 201);
            
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, User $user)
    {     
        try {
            $validator = Validator::make($request->all(), [
                'nome' => '',
                'sobrenome'=> '',
                'telefone'=> '',
                'email'=> '',
                'password'=> '',
            ]);
         
            if ($validator->fails()) {
                return response()->json(['Error' => $validator->errors()], 400);
            }

            $usuario = $this->usuarioService->atualizarUsuario($user ,$request->all());

            if($usuario)
                return response()->json(['Message' => 'Usuário atualizado com sucesso.', 'data' => $user], 200);

            return response()->json(['Message' => 'Não foi possivel atualizar o usuário.'], 500);
                
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }        
    }

    public function destroy($userId)
    {
        try {
            $user = $this->usuarioService->excluirUsuario($userId);
            if($user) {
                return response()->json(['Message' => 'Usuário excluído com sucesso.'], 200);
            }
            return response()->json(['Message' => 'Usuário não encontrado.'], 404);
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }
}
