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
                UPPER(TRIM(prod_cod)) AS sku,
                LOWER(TRIM(prod_nome)) AS nome
            FROM produtos_base
            WHERE prod_atv = 1
        ");

        DB::statement("
            CREATE VIEW view_precos AS
            SELECT
                UPPER(TRIM(prc_cod_prod)) AS sku,
                CASE
                WHEN prc_valor LIKE '%,%' THEN
                    REPLACE(REPLACE(TRIM(prc_valor), '.', ''), ',', '.')
                ELSE
                    TRIM(prc_valor)
            END AS valor_raw
            FROM precos_base
            WHERE LOWER(TRIM(prc_status)) = 'ativo'
            AND prc_valor NOT LIKE '%sem preço%'
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
