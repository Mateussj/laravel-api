<?php

namespace App\Http\Controllers;
use App\Services\ApiExternaService;

class ApiExternaController extends Controller{
     protected $apiExternaService;

     public function __construct(ApiExternaService $apiExternaService)
     {
          $this->apiExternaService = $apiExternaService;
     }

     public function getAll(){
          return $this->apiExternaService->getAllApiExterna();
     }

     public function findApiExterna($id){
          return $this->apiExternaService->findApiExterna($id);
     }
}