<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Repositories\Usuarios\UsuarioRepository;
use App\Services\Usuario\UsuarioService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioTest extends TestCase  
{   
    
    use RefreshDatabase;

    public function testCreateUser()
    {
        // Crie uma instância simulada do UserRepository usando o método "mock" do PHPUnit
        $usuarioRepository = $this->getMockBuilder(UsuarioRepository::class)
        ->disableOriginalConstructor()
        ->getMock(); 
        
        // Defina o comportamento esperado para o método "create" do UserRepository
        $usuarioRepository->expects($this->once())
            ->method('create')
            ->willReturn(new User([
                'nome' => 'TesteNome',
                'sobrenome' => 'TesteSobrenome',
                'email' => 'testeemail@example.com',
                'password' => 'password123',
                'telefone' => '9787877'
            ]));

        // Crie uma instância do UserService e injete o UserRepository simulado
        $usuarioService = new UsuarioService($usuarioRepository);

        // Chame o método createUser do usuarioService
        $user = $usuarioService->create([
            'nome' => 'TesteNome',
            'sobrenome' => 'TesteSobrenome',
            'email' => 'testeemail@example.com',
            'password' => 'password123',
            'telefone' => '9787877'
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('TesteNome', $user->nome);
        $this->assertEquals('TesteSobrenome', $user->sobrenome);
        $this->assertEquals('testeemail@example.com', $user->email);
        $this->assertEquals('password123', $user->password);
        $this->assertEquals('9787877', $user->telefone);
    }
}
