<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsusarioControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */


       public function testcheandoSeIndexRetornaOsUsuariosCorretamente(){
              User::factory()->count(5)->create();
              $response = $this->get('/api/users');
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
              $user = User::factory()->count(1)->create();
              
              $response = $this->get("/api/users/{$user[0]->id}");
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
       }

       public function testChecandoSeUpdateAtualizaUmUsuario(){
              $user = User::factory()->count(1)->create();
              $new = [
                     'nome' => "Name Teste", 
                     'email' => "Email@Teste.com", 
                     'telefone' => "988888555"
              ];

              $response = $this->put("/api/users/{$user[0]->id}", $new);
              $response->assertStatus(200);
              $response->assertJson(
                     [
                            'message' => 'Usuário atualizado com sucesso.',
                            'data' => $new
                     ]);

       }

       public function testChecandoSeDeleteExcluiUmUsuario(){
              $user = User::factory()->count(1)->create();

              $response = $this->delete("/api/users/{$user[0]->id}");
              $response->assertStatus(200);
              $response->assertJson(
                     [
                            'message' => 'Usuário excluído com sucesso.',
                     ]);

       }

}
