<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE VIEW view_produtos AS
        SELECT
            LOWER(TRIM(nome)) AS nome,
            UPPER(TRIM(sku)) AS sku
        FROM produtos_base
        WHERE ativo = 1
    ");

        DB::statement("
        CREATE VIEW view_precos AS
        SELECT
            UPPER(TRIM(sku)) AS sku,
            ROUND(valor, 2) AS valor
        FROM precos_base
        WHERE ativo = 1
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_produtos");
        DB::statement("DROP VIEW IF EXISTS view_precos");
    }
};
