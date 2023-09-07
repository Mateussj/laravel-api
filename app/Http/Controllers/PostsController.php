<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Services\Posts\PostsService;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    private $postService;

    public function __construct(PostsService $postService){
        $this->postService = $postService;
    }

    public function index()
    {
        try {
            $users = $this->postService->findAll();

            if($users)
                return response()->json($users, 200);

            return response()->json(['Message' => 'Nenhum Post encontrado'], 404);

        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->postService->find($id);
            
            if($user)
                return response()->json($user, 200);

            return response()->json(['Message' => 'Post não encontrado'], 404);
            
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {        
        try {

            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'conteudo' => 'required'
            ]);
 
            if ($validator->fails()) {
                return response()->json(['Error' => $validator->errors()], 400);
            }

            $post = $this->postService->create($request->all());

            if($post)
                return response()->json($post, 201);
            
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Posts $post)
    {     
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => '',
                'conteudo'=> ''
            ]);
         
            if ($validator->fails()) {
                return response()->json(['Error' => $validator->errors()], 400);
            }

            $post = $this->postService->update($post ,$request->all());

            if($post)
                return response()->json(['Message' => 'Post atualizado com sucesso.'], 200);

            return response()->json(['Message' => 'Não foi possivel atualizar o Post.'], 500);
                
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }        
    }

    public function destroy($userId)
    {
        try {
            $user = $this->postService->delete($userId);
            if($user) {
                return response()->json(['Message' => 'Post excluído com sucesso.'], 200);
            }
            return response()->json(['Message' => 'Post não encontrado.'], 404);
        } catch (Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 500);
        }
    }
}
