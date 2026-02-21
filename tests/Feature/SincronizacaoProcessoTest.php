<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test; // Import para remover os avisos

class SincronizacaoProcessoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\ProdutoBaseSeeder::class);
        $this->seed(\Database\Seeders\PrecoBaseSeeder::class);
    }

    #[Test]
    public function deve_sincronizar_produtos_com_sucesso()
    {
        $response = $this->postJson('/api/sincronizar/produtos');

        $response->assertStatus(200);

        $this->assertDatabaseHas('produto_insercao', [
            'sku' => 'PRD001',
            'nome' => 'teclado  mecânico   rgb'
        ]);
    }

    #[Test]
    public function deve_sincronizar_precos_com_sucesso_apos_produtos()
    {
        $this->postJson('/api/sincronizar/produtos');

        $response = $this->postJson('/api/sincronizar/precos');

        $response->assertStatus(200);
        $this->assertDatabaseHas('preco_insercao', [
            'sku' => 'PRD001',
            'valor' => 499.90
        ]);
    }

    #[Test]
    public function nao_deve_retornar_erro_500_se_sincronizar_precos_antes_de_produtos()
    {
        $response = $this->postJson('/api/sincronizar/precos');

        $response->assertStatus(200);
        $this->assertEquals(0, DB::table('preco_insercao')->count());
    }

    #[Test]
    public function deve_retornar_listagem_paginada_de_produtos_e_precos()
    {
        $this->postJson('/api/sincronizar/produtos');
        $this->postJson('/api/sincronizar/precos');

        $response = $this->getJson('/api/produtos-precos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['sku', 'nome', 'valor']
                ],
                'current_page',
                'total'
            ]);
    }
}