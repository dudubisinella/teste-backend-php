<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrecoBaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('precos_base')->insert([
            ['sku' => 'abc123', 'valor' => 10.50, 'ativo' => 1],
            ['sku' => 'xyz789', 'valor' => 25.00, 'ativo' => 1],
        ]);
    }
}
