<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Posts;

class PostsTest extends TestCase
{
     public function testChecarSePostsContemOsCamposObrigatorios()
     {
            $posts = new Posts();
            $colunasNecessarias = [
                  0 => "conteudo",
                  1 => "user_id"
            ];
        
            $this->assertEquals($colunasNecessarias, $posts->getFillable());
      }
}