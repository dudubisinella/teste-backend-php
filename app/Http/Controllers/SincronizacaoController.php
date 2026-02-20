<?php

namespace App\Http\Controllers;

use App\Services\SincronizacaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SincronizacaoController extends Controller
{
    public function sincronizarProdutos(SincronizacaoService $service)
    {
        $service->sincronizarProdutos();
        return response()->json(['status' => 'produtos sincronizados']);
    }

    public function sincronizarPrecos(SincronizacaoService $service)
    {
        $service->sincronizarPrecos();
        return response()->json(['status' => 'preços sincronizados']);
    }

    public function listar(Request $request)
    {
        $dados = DB::table('produto_insercao as p')
            ->leftJoin('preco_insercao as pr', 'p.sku', '=', 'pr.sku')
            ->select('p.sku', 'p.nome', 'pr.valor')
            ->paginate($request->get('per_page', 15));

        return response()->json($dados);
    }
}
