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

    public function testChecnandoSeFindEncontraUmUsuario(){
        $usuarioRepository = $this->getMockBuilder(UsuarioRepository::class)
        ->disableOriginalConstructor()
        ->getMock();
        
        $usuarioRepository->expects($this->once())
            ->method('find')
            ->willReturn([
                'nome' => 'TesteNome',
                'sobrenome' => 'TesteSobrenome',
                'email' => 'testeemail@example.com',
                'telefone' => '9787877',
                'created_at' => '2023-09-01T21:20:26.000000Z',
                'updated_at' => '2023-10-01T21:20:26.000000Z',
                'id' => 1
            ]);

        $usuarioService = new UsuarioService($usuarioRepository);
       
        $user = $usuarioService->find(1);
        $this->assertEquals('TesteNome', $user['nome']);
        $this->assertEquals('TesteSobrenome', $user['sobrenome']);
        $this->assertEquals('testeemail@example.com', $user['email']);
        $this->assertEquals('9787877', $user['telefone']);
        $this->assertEquals(1, $user['id']);
        $this->assertEquals('2023-09-01T21:20:26.000000Z', $user['created_at']);
        $this->assertEquals('2023-10-01T21:20:26.000000Z', $user['updated_at']);
    }
}
