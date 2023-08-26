<?php

namespace App\Services;

class ApiExternaService {
     public function getAllApiExterna()
     {
          $ch = curl_init(env('API_EXTERNA').'/posts');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 'GET');
          $response = curl_exec($ch);
          
          if ($response !== false) {
               return json_decode($response, true);
          }
          
          return null;
     }

     public function findApiExterna($id)
     {
          $ch = curl_init(env('API_EXTERNA')."/posts/$id");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 'GET');
          $response = curl_exec($ch);
          
          if ($response !== false) {
               return json_decode($response, true);
          }
          
          return null;
     }
}