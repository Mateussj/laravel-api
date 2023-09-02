<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
class UsusarioControllerTest extends TestCase
{
    use RefreshDatabase;
  
       private $token;

       public function setUp(): void {
              parent::setUp();
              $this->token = $this->criarUsuarios();
       }
       
       public function criarUsuarios(){
              User::factory(5)->create();
              $user = User::first();
              $token = Str::random(60);
              $user->api_token = hash('sha256', $token);
              $user->save();
              return $token;
       }

       public function testCheandoSeIndexRetornaOsUsuariosCorretamente(){
                     
              $response = $this->withHeaders([
              'Authorization' => 'Bearer ' . $this->token,
              ])->get('/api/users');
              
              $response->assertStatus(200);
              $response->assertJson(['data' => []]);
              $response->assertJsonCount(5, 'data');
              $response->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'nome',
                             'sobrenome',
                             'telefone',
                             'email',
                             'created_at',
                             'updated_at'
                            ]
                     ],
                     'current_page',
                     'first_page_url',
                     'from',
                     'last_page',
                     'last_page_url',
                     'links',
                     'next_page_url',
                     'path',
                     "per_page",
                     "prev_page_url",
                     "to",
                     "total"
                 ]);
       }

       public function testChecandoSeShowRetornaUmUsuario(){
              
              $user = User::first();
              
              $response = $this->withHeaders([
                     'Authorization' => 'Bearer ' . $this->token,
                     ])->get("/api/users/{$user->id}");
              
              $response->assertStatus(200);
              $response->assertJsonStructure(
                     [
                            "nome",
                            "sobrenome",
                            "telefone",
                            "email",
                            "created_at",
                            "updated_at"
                     ]);

              $response = $this->withHeaders([
                     'Authorization' => 'Bearer ' . $this->token,
                     ])->get("/api/users/10000");
              
              $response->assertStatus(404);
              $response->assertJson(['Message' => 'Usuário não encontrado']);
       }

       public function testChecandoSeUpdateAtualizaUmUsuario(){
              $user = User::first();
              $new = [
                     'nome' => "Name Teste", 
                     'email' => "Email@Teste.com", 
                     'telefone' => "988888555"
              ];

              $response = $this->withHeaders([
                     'Authorization' => 'Bearer ' . $this->token,
                     ])->put("/api/users/{$user->id}", $new);
              $response->assertStatus(200);
              $response->assertJson(
                     [
                            'Message' => 'Usuário atualizado com sucesso.',
                            'data' => $new
                     ]);
              $response = $this->withHeaders([
                     'Authorization' => 'Bearer ' . $this->token,
                     ])->put("/api/users/11111", $new);
              $response->assertStatus(404);

       }

       public function testChecandoSeStoreCriaUmUsuario(){

              // checa se cricacao de usuario acotece normalemente
              $user = [
                     "nome" => "Teste",
                     "sobrenome" => "Teste",
                     "email" => "teste@teste.com.br",
                     "password" => "123",
                     "confirm_password" => "123",
                     "telefone" => ""
              ];
              $response = $this->withHeaders([
                     'Authorization' => 'Bearer ' . $this->token,
                     ])->post("/api/users", $user);

              $response->assertStatus(201);
              $response->assertJsonStructure([
                     "nome",
                     "sobrenome",
                     "email",
                     "updated_at",
                     "created_at",
                     "id"
              ]);

              //checa se o ususario ja nao esta cadastrado. e retorna erro dizendo que email ja esta cadastrado.
              $response = $this->withHeaders([
                     'Authorization' => 'Bearer ' . $this->token,
                     ])->post("/api/users", $user);

              $response->assertStatus(400);
              $response->assertJsonStructure([
                     "Error" => ["email"]
              ]);

              //checa se validacao de senha e confirmacao de senha funcionam
              $userSenhaErrada= [
                     "nome" => "Teste",
                     "sobrenome" => "Teste",
                     "email" => "teste2@teste.com.br",
                     "password" => "123",
                     "confirm_password" => "444444",
                     "telefone" => ""
              ];

              $response = $this->withHeaders([
                     'Authorization' => 'Bearer ' . $this->token,
                     ])->post("/api/users", $userSenhaErrada);

              $response->assertStatus(400);
              $response->assertJson(["Error" => "As senhas recebidas em password e confirm_password, não conferem."]);

              //checa se email e senha são obrigatorios
              $userSemSenhaEEmail= [
                     "nome" => "Teste",
                     "sobrenome" => "Teste",
                     "email" => "",
                     "password" => "",
                     "confirm_password" => "",
                     "telefone" => "1111"
              ];

              $response = $this->withHeaders([
                     'Authorization' => 'Bearer ' . $this->token,
                     ])->post("/api/users", $userSemSenhaEEmail);

              $response->assertStatus(400);
              $response->assertJsonStructure([
                     "Error" => ["email", "password", "confirm_password"]
              ]);
              
              //dd($response);
       }

       public function testChecandoSeDeleteExcluiUmUsuario(){
              $user = User::first();

              $response = $this->withHeaders([
                     'Authorization' => 'Bearer ' . $this->token,
                     ])->delete("/api/users/1111");
              $response->assertStatus(404);

              $response = $this->withHeaders([
                     'Authorization' => 'Bearer ' . $this->token,
                     ])->delete("/api/users/{$user->id}");
              $response->assertStatus(200);
              $response->assertJson(
                     [
                            'Message' => 'Usuário excluído com sucesso.',
                     ]);
              $response = $this->withHeaders([
                     'Authorization' => 'Bearer ' . $this->token,
                     ])->delete("/api/users/{$user->id}");
              $response->assertStatus(401);
       }



}
