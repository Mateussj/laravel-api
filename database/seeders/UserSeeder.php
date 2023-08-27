<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
        $quantidadeNecessariaDeUsuarios = 100000;
        $quantidadeCriadaPorLote = 5000;
        $quantidadeDelotes = $quantidadeNecessariaDeUsuarios / $quantidadeCriadaPorLote;

        for ($i = 0; $i < $quantidadeDelotes; $i++) {
            User::factory()->times($quantidadeCriadaPorLote)->create();
            $this->command->info("Lote " . ($i + 1) . " criado.");
        }
    }
}
