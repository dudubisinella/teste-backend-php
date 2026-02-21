<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SincronizacaoService
{
    public function sincronizarProdutos(): void
    {
        $dados = DB::table('view_produtos')->get();

        foreach ($dados as $item) {
            DB::table('produto_insercao')->updateOrInsert(
                ['sku' => $item->sku],
                ['nome' => $item->nome]
            );
        }

        $skus = $dados->pluck('sku')->toArray();

        DB::table('produto_insercao')
            ->whereNotIn('sku', $skus)
            ->delete();
    }

    public function sincronizarPrecos(): void
    {
        $dados = DB::table('view_precos')->get();

        foreach ($dados as $item) {

            $produtoExiste = DB::table('produto_insercao')
                ->where('sku', $item->sku)
                ->exists();

            if ($produtoExiste) {
                DB::table('preco_insercao')->updateOrInsert(
                    ['sku' => $item->sku],
                    ['valor' => $item->valor_raw]
                );
            }
        }

        $skusNaView = $dados->pluck('sku')->toArray();

        DB::table('preco_insercao')
            ->whereNotIn('sku', $skusNaView)
            ->delete();
    }
}
