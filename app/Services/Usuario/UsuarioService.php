<?php

namespace App\Services\Usuario;
use App\Models\User;
use App\Repositories\Usuarios\UsuarioRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Usuarios\UsuarioRepositoryInterface;
use Exception;

class UsuarioService {

     protected $usuarioRepository;

     public function __construct(UsuarioRepository $usuarioRepository)
     {
         $this->usuarioRepository = $usuarioRepository;
     }
     
     public function create($dados)
     {
          try {
               $user = [
                    'nome' => $dados['nome'],
                    'sobrenome' => $dados['sobrenome'] ? $dados['sobrenome'] : null,
                    'telefone' => $dados['telefone'] ? $dados['telefone'] : null,
                    'email' => $dados['email'],
                    'password' => Hash::make($dados['password'])
               ];
               return $this->usuarioRepository->create($user);

          } catch (Exception $e) {
               throw new Exception('Não foi possível criar o usuário. ' . $e->getMessage() );
          }
     }

     public function find($id){
          try {
               $user = $this->usuarioRepository->find($id);
               if($user)
                    return $user;
               return null;
           } catch (Exception $e) {
               throw new Exception('Não foi possível encontrar o usuário.');
           }
     }

     public function findAll(){
          try {
               return  User::paginate(10);
           } catch (Exception $e) {
               throw new Exception('Não foi possivel encontrar os usuários.');
           }
     }

     public function update($user, $dados){

          try {
               return $this->usuarioRepository->update($user, $dados);
          } catch (Exception $e) {
               throw new Exception('Não foi possível atualizar o usuário.');
          }
     }

     public function delete($userId){
          try {
               $user = $this->usuarioRepository->find($userId);
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