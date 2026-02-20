<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutoBaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produtos_base')->insert([
            ['nome' => 'Produto A', 'sku' => 'abc123', 'ativo' => 1],
            ['nome' => 'Produto B', 'sku' => 'xyz789', 'ativo' => 1],
        ]);
    }
}
