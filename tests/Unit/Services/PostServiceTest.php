<?php

namespace Tests\Unit\Services;

use App\Models\Posts;
use App\Repositories\Posts\PostsRepository;
use App\Repositories\Usuarios\UsuarioRepository;
use App\Services\Posts\PostsService;
use App\Services\Usuario\UsuarioService;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostServiceTest extends TestCase  
{   
    
    use RefreshDatabase;
    
    private $user;

    public function setUp(): void {
           parent::setUp();
           $usuarioRepository = new UsuarioRepository();
           $usuarioService = new UsuarioService($usuarioRepository);
           $this->user = $usuarioService->create([
               'nome' => 'TesteNome',
               'sobrenome' => 'TesteSobrenome',
               'email' => 'testeemail@example.com',
               'password' => 'password123',
               'telefone' => '9787877'
           ]);
    }

    public function testChecandoSeCreateCriaUmPost()
    {
        $postRepository = new PostsRepository();
        $postService = new PostsService($postRepository);
        $post = $postService->create([
            'user_id' => $this->user->id,
            'conteudo' => 'Teste conteudo',
        ]);

        $this->assertInstanceOf(Posts::class, $post);
        $this->assertEquals(1, $post->user_id);
        $this->assertEquals('Teste conteudo', $post->conteudo);
      
    }

    public function testChecandoSeCreateRetornaUmaExceptionCorretamenteSeconteudoNaoForFornecido(){
        $postRepository = $this->getMockBuilder(PostsRepository::class)
        ->disableOriginalConstructor()
        ->getMock();

        $postService = new PostsService($postRepository);
        $this->expectException(Exception::class);
        $postService->create([
            'user_id' => $this->user->id
        ]);  
        
    }

    public function testChecandoSeCreateRetornaUmaExceptionCorretamenteSeUserIdNaoForFornecido(){
        $postRepository = $this->getMockBuilder(PostsRepository::class)
        ->disableOriginalConstructor()
        ->getMock();

        $postService = new PostsService($postRepository);
        $this->expectException(Exception::class);
        $postService->create([
            'conteudo' => 'Teste conteudo'
        ]);   
    }

    public function testChecnandoSeFindEncontraUmPost(){
        $postRepository = $this->getMockBuilder(PostsRepository::class)
        ->disableOriginalConstructor()
        ->getMock();
        
        $postRepository->expects($this->once())
            ->method('find')
            ->willReturn([
                'conteudo' => 'Teste conteudo',
                'user_id' => 2,
                'id' => 1
            ]);

        $postService = new PostsService($postRepository);
       
        $post = $postService->find(1);
        $this->assertEquals(2, $post['user_id']);
        $this->assertEquals('Teste conteudo', $post['conteudo']);
        $this->assertEquals(1, $post['id']);
    }

    public function testChecnandoSeFindRetornaNullCorretamente(){
        $postRepository = $this->getMockBuilder(PostsRepository::class)
        ->disableOriginalConstructor()
        ->getMock();
        
        $postRepository->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $postService = new PostsService($postRepository);
       
        $post = $postService->find(1);
        $this->assertEquals($post, null);
    }

    public function testChecnandoSeFindAllRetornaDadosPaginadosCorretamente(){
        $postRepository = $this->getMockBuilder(PostsRepository::class)
        ->disableOriginalConstructor()
        ->getMock();
        
        $paginatorMock = \Mockery::mock(LengthAwarePaginator::class);
        
        $postRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($paginatorMock);

        $postService = new PostsService($postRepository);
       
        $post = $postService->findAll(1);
        $this->assertInstanceOf(LengthAwarePaginator::class, $post);
    }

     public function testChecnandoSeUpdateRetornaCorretamente(){
        $postRepository = $this->getMockBuilder(PostsRepository::class)
        ->disableOriginalConstructor()
        ->getMock();
        
        $postRepository->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $postService = new PostsService($postRepository);
        $postagem = new Posts();

        $post = $postService->update($postagem, []);
        $this->assertEquals(true, $post);
        $this->assertEquals('boolean', gettype($post));

        $postRepository = $this->getMockBuilder(PostsRepository::class)
        ->disableOriginalConstructor()
        ->getMock();

        $postRepository->expects($this->once())
        ->method('update')
        ->willReturn(false);

        $postService = new PostsService($postRepository);

        $post = $postService->update($postagem, []);
        $this->assertEquals(false, $post);
        $this->assertEquals('boolean', gettype($post));
    }

    public function testChecnandoSeDeleteRetornaCorretamente(){
        $postRepository = $this->getMockBuilder(PostsRepository::class)
        ->disableOriginalConstructor()
        ->getMock();
        
        $postRepository->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $postService = new PostsService($postRepository);

        $post = $postService->delete(1);
        $this->assertEquals(true, $post);
        $this->assertEquals('boolean', gettype($post));

        $postRepository = $this->getMockBuilder(PostsRepository::class)
        ->disableOriginalConstructor()
        ->getMock();

        $postRepository->expects($this->once())
        ->method('delete')
        ->willReturn(false);

        $postService = new PostsService($postRepository);

        $post = $postService->delete(1);
        $this->assertEquals(false, $post);
        $this->assertEquals('boolean', gettype($post));
    }
}
