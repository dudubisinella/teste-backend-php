<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('preco_insercao', function (Blueprint $table) {
            $table->id();

            $table->string('sku', 30);
            $table->decimal('valor', 12, 2);

            $table->timestamps();

            $table->foreign('sku')
                ->references('sku')
                ->on('produto_insercao')
                ->onDelete('cascade');

            $table->unique('sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preco_insercao');
    }
};
