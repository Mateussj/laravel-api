<?php

namespace App\Services;

class MatrizService {
     

      /**
     * @param Array $menu
     */  
     public function handle($menu) : string
     {    
          try {
               return $this->organizaMenu($menu);
          } catch (\Exception $e) {
               return "error: ". $e->getMessage();
          }
          
     }
     
     function organizaMenu($menus, $subId = null, $prefix = ''): string {
          $outPut = '';
          foreach ($menus as $menu) {
               if ($menu['sub'] == $subId) {
                    $outPut .= $prefix . '- ' . $menu['name'] . "\n";
                    $outPut .= $this->organizaMenu($menus, $menu['id'], $prefix . '- ');
               }
          }
          return $outPut;
     }
}