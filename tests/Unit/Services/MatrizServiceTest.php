<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\MatrizService;
use Mockery\Matcher\Type;

class MatrizServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */


     public function testChecarSeOrganizaMenuFunciona()
     {
         $menuService = new MatrizService();
         
         $menus = [
             [
                 "id" => 1,
                 "sub" => null,
                 "name" => 'Calçados'
             ],
             [
                 "id" => 2,
                 "sub" => 3,
                 "name" => 'Bonés'
             ],
             [
                 "id" => 3,
                 "sub" => null,
                 "name" => 'Acessórios'
             ],
             [
                 "id" => 4,
                 "sub" => 1,
                 "name" => 'Botas'
             ],
             [
                 "id" => 5,
                 "sub" => 4,
                 "name" => 'POLO PLUS'
             ]
         ];
 
         $expectedOutput = "- Calçados\n- - Botas\n- - - POLO PLUS\n- Acessórios\n- - Bonés\n";
         $this->assertEquals($expectedOutput, $menuService->organizaMenu($menus));
     }

     public function testChecarSeHandleProduzUmaSaidaCorreta(){

          $menus = [
               [
                    "id" => 5,
                    "sub" => 4,
                    "name" => 'POLO PLUS'
                ]
          ];

          $menuService = new MatrizService();
          $this->assertEquals("string", gettype($menuService->handle($menus)));
     }

     public function testChecarSeHandleProcessaArgumentosInvalidos(){

          $menuService = new MatrizService();
          $this->assertEquals("string", gettype($menuService->handle([])));
          $this->assertEquals("string", gettype($menuService->handle(1)));
          $this->assertEquals("string", gettype($menuService->handle(null)));
          $this->assertStringContainsString("error", $menuService->handle(1));

     }
}
