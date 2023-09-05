<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Repositories\Usuarios\UsuarioRepository;
use App\Services\Usuario\UsuarioService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioTest extends TestCase  
{   
    
    use RefreshDatabase;

    public function testChecandoSeCreateCriaUmUsuario()
    {
        $usuarioRepository = $this->getMockBuilder(UsuarioRepository::class)
        ->disableOriginalConstructor()
        ->getMock();
        
        $usuarioRepository->expects($this->once())
            ->method('create')
            ->willReturn(new User([
                'nome' => 'TesteNome',
                'sobrenome' => 'TesteSobrenome',
                'email' => 'testeemail@example.com',
                'password' => 'password123',
                'telefone' => '9787877'
            ]));

        $usuarioService = new UsuarioService($usuarioRepository);

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

    public function testChecandoSeCreateRetornaUmaExceptionCorretamenteSePasswordNaoForFornecido(){
        $usuarioRepository = $this->getMockBuilder(UsuarioRepository::class)
        ->disableOriginalConstructor()
        ->getMock();

        $usuarioService = new UsuarioService($usuarioRepository);
        $this->expectException(Exception::class);
        $usuarioService->create([
            'nome' => 'TesteNome',
            'sobrenome' => 'TesteSobrenome',
            'email' => 'testeemail@example.com',
            'telefone' => '9787877'
        ]);  
        
    }

    public function testChecandoSeCreateRetornaUmaExceptionCorretamenteSeNomeNaoForFornecido(){
        $usuarioRepository = $this->getMockBuilder(UsuarioRepository::class)
        ->disableOriginalConstructor()
        ->getMock();

        $usuarioService = new UsuarioService($usuarioRepository);
        $this->expectException(Exception::class);
        $usuarioService->create([
            'sobrenome' => 'TesteSobrenome',
            'email' => 'testeemail@example.com',
            'password' => '123',
            'telefone' => '9787877'
        ]);   
    }

    public function testChecandoSeCreateRetornaUmaExceptionCorretamenteSeEmailNaoForFornecido(){
        $usuarioRepository = $this->getMockBuilder(UsuarioRepository::class)
        ->disableOriginalConstructor()
        ->getMock();

        $usuarioService = new UsuarioService($usuarioRepository);
        $this->expectException(Exception::class);
        $usuarioService->create([
            'nome' => 'TesteNome',
            'sobrenome' => 'TesteSobrenome',
            'password' => '123',
            'telefone' => '9787877'
        ]);
    }
}
