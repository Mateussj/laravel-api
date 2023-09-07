<?php

namespace App\Services\Posts;
use App\Repositories\Posts\PostsRepository;
use Exception;

class PostsService {

     protected $postsRepository;

     public function __construct(PostsRepository $postsRepository)
     {
         $this->postsRepository = $postsRepository;
     }
     
     public function create($dados)
     {
          try {
               $user = [
                    'user_id' => $dados['user_id'],
                    'conteudo' => $dados['conteudo'],
               ];
               return $this->postsRepository->create($user);
          } catch (Exception $e) {
               throw new Exception('Não foi possível criar o post. ');
          }
     }

     public function find($id){
          try {
               $user = $this->postsRepository->find($id);
               if($user)
                    return $user;
               return null;
           } catch (Exception $e) {
               throw new Exception('Não foi possível encontrar o post.');
           }
     }

     public function findAll($perPage = 10){
          try {
               return $this->postsRepository->findAll($perPage);
           } catch (Exception $e) {
               throw new Exception('Não foi possivel encontrar os Postss.');
           }
     }

     public function update($user, $dados){

          try {
               return $this->postsRepository->update($user, $dados);
          } catch (Exception $e) {
               throw new Exception('Não foi possível atualizar o post.');
          }
     }

     public function delete($userId){
          try {
               $user = $this->postsRepository->delete($userId);
               if($user) {
                   return true;
               }
               return false;
           } catch (Exception $e) {
               throw new Exception('Não foi possível excluir o post.');
           }
     }

}