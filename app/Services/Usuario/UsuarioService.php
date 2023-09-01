<?php

namespace App\Services\Usuario;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class UsuarioService {

     public function criarUsuario($dados)
     {
          try {
               return User::create([
                    'nome' => $dados['nome'],
                    'sobrenome' => $dados['sobrenome'],
                    'telefone' => $dados['telefone'],
                    'email' => $dados['email'],
                    'password' => Hash::make($dados['password']),
               ]);
          } catch (Exception $e) {
               throw new Exception('Não foi possível criar o usuário.');
          }
     }

     public function buscarUsuario($id){
          try {
               return User::find($id);
           } catch (Exception $e) {
               throw new Exception('Não foi possível criar o usuário.');
           }
     }

     public function buscarTodosUsuarios(){
          try {
               return  User::paginate(10);
           } catch (Exception $e) {
               throw new Exception('Não foi possível criar o usuário.');
           }
     }

     public function atualizarUsuario($user, $dados){

          try {
               return $user->update($dados);
          } catch (Exception $e) {
               throw new Exception('Não foi possível atualizar o usuário.');
          }
     }

     public function excluirUsuario($userId){
          try {
               $user = User::find($userId);
               if($user) {
                   $user->delete();
                   return true;
               }
               return false;
           } catch (Exception $e) {
               throw new Exception('Não foi possível excluir o usuário.');
           }
     }

}