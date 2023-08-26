<?php

namespace App\Http\Controllers;
use App\Services\MatrizService;

class MatrizController extends Controller{
     protected $matrizService;

     public function __construct(MatrizService $matrizService)
     {
          $this->matrizService = $matrizService;
     }

     public function get(){

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

          return $this->matrizService->handle($menus);
     }
}