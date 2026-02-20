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
        Schema::create('precos_base', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->decimal('valor', 12, 2);
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->index('sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precos_base');
    }
};