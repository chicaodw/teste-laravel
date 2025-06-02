<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        }

        return $this->vendedorDashboard();
    }

    private function adminDashboard()
    {
        // Vendas mensais (todas)
        $vendas = Venda::selectRaw('MONTH(created_at) as mes, SUM(total) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $vendasMensais = array_fill(1, 12, 0);
        foreach ($vendas as $venda) {
            $vendasMensais[(int) $venda->mes] = (float) $venda->total;
        }

        // Produtos mais vendidos (via tabela pivot produto_venda)
        $produtosMaisVendidos = DB::table('produto_venda')
            ->join('produtos', 'produto_venda.produto_id', '=', 'produtos.id')
            ->select('produtos.nome', DB::raw('SUM(produto_venda.quantidade) as quantidade'))
            ->groupBy('produtos.id', 'produtos.nome')
            ->orderByDesc('quantidade')
            ->limit(5)
            ->get();

        // Vendas por colaborador
        $vendasPorColaborador = Venda::selectRaw('user_id, SUM(total) as total')
            ->groupBy('user_id')
            ->with('user:id,name')
            ->get();

        $colaboradores = $vendasPorColaborador->pluck('user.name');
        $valoresColaboradores = $vendasPorColaborador->pluck('total');

        // Estoque atual
        $estoqueAtual = Produto::select('nome', 'estoque')->get();
        $nomesEstoque = $estoqueAtual->pluck('nome');
        $quantidadesEstoque = $estoqueAtual->pluck('estoque');

        // Clientes por mês
        $clientesPorMes = Cliente::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $clientesPorMesLabels = [];
        $clientesPorMesValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $clientesPorMesLabels[] = date('M', mktime(0, 0, 0, $i, 1));
            $clientesPorMesValues[] = (float) ($clientesPorMes->firstWhere('mes', $i)->total ?? 0);
        }

        return view('dashboard', [
            'totalClientes' => Cliente::count(),
            'totalProdutos' => Produto::count(),
            'totalColaboradores' => User::where('role', 'vendedor')->count(),
            'totalVendas' => Venda::count(),
            'faturamento' => Venda::sum('total'),

            'meses' => array_map(fn($i) => date('M', mktime(0, 0, 0, $i, 1)), range(1, 12)),
            'valoresMensais' => array_values($vendasMensais),

            'produtosNomes' => $produtosMaisVendidos->pluck('nome'),
            'produtosQuantidades' => $produtosMaisVendidos->pluck('quantidade'),

            'colaboradores' => $colaboradores,
            'vendasPorColaborador' => $valoresColaboradores,

            'nomesEstoque' => $nomesEstoque,
            'quantidadesEstoque' => $quantidadesEstoque,

            'clientesPorMesLabels' => $clientesPorMesLabels,
            'clientesPorMesValues' => $clientesPorMesValues,
        ]);
    }

    private function vendedorDashboard()
    {
        $userId = auth()->id();

        // Vendas mensais (somente do vendedor)
        $vendas = Venda::where('user_id', $userId)
            ->selectRaw('MONTH(created_at) as mes, SUM(total) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $vendasMensais = array_fill(1, 12, 0);
        foreach ($vendas as $venda) {
            $vendasMensais[(int) $venda->mes] = (float) $venda->total;
        }

        // Produtos mais vendidos pelo vendedor
        $produtosMaisVendidos = DB::table('produto_venda')
            ->join('vendas', 'produto_venda.venda_id', '=', 'vendas.id')
            ->join('produtos', 'produto_venda.produto_id', '=', 'produtos.id')
            ->where('vendas.user_id', $userId)
            ->select('produtos.nome', DB::raw('SUM(produto_venda.quantidade) as quantidade'))
            ->groupBy('produtos.id', 'produtos.nome')
            ->orderByDesc('quantidade')
            ->limit(5)
            ->get();

        $totalVendas = Venda::where('user_id', $userId)->count();
        $faturamento = Venda::where('user_id', $userId)->sum('total');
        $ticketMedio = $totalVendas ? ($faturamento / $totalVendas) : 0;

        return view('dashboard', [
            'totalVendas' => $totalVendas,
            'faturamento' => $faturamento,
            'ticketMedio' => $ticketMedio,

            'meses' => array_map(fn($i) => date('M', mktime(0, 0, 0, $i, 1)), range(1, 12)),
            'valoresMensais' => array_values($vendasMensais),

            'produtosNomes' => $produtosMaisVendidos->pluck('nome'),
            'produtosQuantidades' => $produtosMaisVendidos->pluck('quantidade'),
        ]);
    }
}
