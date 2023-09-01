<?php

namespace Tests\Unit\Models;

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
               5 => "api_token"
         ];
        
          $this->assertEquals($colunasNecessarias, $user->getFillable());
     }

     public function testChecarSePasswordEstaOculto(){
        $user = new User();
        $colunasOcultas = [
              0 => "password",
              1 => "api_token"
        ];
       
         $this->assertEquals($colunasOcultas, $user->getHidden());
     }


}
