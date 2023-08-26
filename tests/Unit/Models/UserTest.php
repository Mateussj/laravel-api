<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */


     public function testChecarSeUsuarioContemOsCamposObrigatorios()
     {
         $user = new User();
         $colunasNecessarias = [
               0 => "nome",
               1 => "sobrenome",
               2 => "telefone",
               3 => "email",
               4 => "password",
         ];
        
          $this->assertEquals($colunasNecessarias, $user->getFillable());
     }


}
