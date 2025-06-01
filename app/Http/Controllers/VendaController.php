<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;

class VendaController extends Controller{
    
    public function index(){
        if (auth()->user()->role === 'admin') {
            $vendas = Venda::with('cliente', 'user')->latest()->get();
        } else {
            $vendas = Venda::with('cliente', 'user')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
        }

        return view('vendas.index', compact('vendas'));
    }

    
    public function create(){
        $clientes = Cliente::all();
        $produtos = Produto::all();
        return view('vendas.create', compact('clientes', 'produtos'));
    }

    public function store(Request $request){
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produtos' => 'required|array',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
        ]);

        $total = 0;
        $produtosParaVenda = [];

        foreach ($request->produtos as $produtoId => $produtoData) {
            $produto = Produto::findOrFail($produtoId);
            $quantidade = $produtoData['quantidade'];

            if ($produto->estoque < $quantidade) {
                return redirect()->back()->withErrors([
                    'estoque' => "Estoque insuficiente para o produto {$produto->nome}."
                ])->withInput();
            }

            $produtosParaVenda[] = [
                'produto' => $produto,
                'quantidade' => $quantidade,
                'subtotal' => $produto->preco * $quantidade
            ];

            $total += $produto->preco * $quantidade;
        }

        $venda = Venda::create([
            'cliente_id' => $request->cliente_id,
            'total' => $total,
            'user_id' => auth()->id(),
        ]);

    foreach ($produtosParaVenda as $item) {
        $produto = $item['produto'];
        $quantidade = $item['quantidade'];

        $produto->estoque -= $quantidade;
        $produto->save();

        $venda->produtos()->attach($produto->id, [
            'quantidade' => $quantidade,
            'preco_unitario' => $produto->preco,
        ]);
    }

    LogHelper::log('Criou venda', 'Venda', $venda->id, 'Cliente ID: ' . $venda->cliente_id . ', Total: R$ ' . number_format($venda->total, 2, ',', '.'));

    return redirect()->route('vendas.index')->with('success', 'Venda registrada com sucesso!');
}
    
    public function show(string $id){
       $venda = Venda::with(['cliente', 'produtos', 'user'])->findOrFail($id);

        if (auth()->user()->role !== 'admin' && $venda->user_id !== auth()->id()) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('vendas.show', compact('venda'));

    }

   
    public function edit(string $id){
        $venda = Venda::with('produtos')->findOrFail($id);

        if (auth()->user()->role !== 'admin' && $venda->user_id !== auth()->id()) {
            abort(403, 'Acesso não autorizado.');
        }
        $clientes = Cliente::all();
        $produtos = Produto::all();

        return view('vendas.edit', compact('venda', 'clientes', 'produtos'));
    }

    
    public function update(Request $request, string $id){
        $venda = Venda::with('produtos')->findOrFail($id);

        if (auth()->user()->role !== 'admin' && $venda->user_id !== auth()->id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
        ]); 
        
        foreach ($venda->produtos as $produto) {
            $produto->estoque += $produto->pivot->quantidade;
            $produto->save();
        }

        $venda->produtos()->detach(); 

        $total = 0;

        foreach ($request->produtos as $produtoData) {
            $produto = Produto::findOrFail($produtoData['id']);

            if ($produto->estoque < $produtoData['quantidade']) {
                return redirect()->back()->with('error', "Estoque insuficiente para o produto {$produto->nome}");
            }

            $produto->estoque -= $produtoData['quantidade'];
            $produto->save();

            $subtotal = $produto->preco * $produtoData['quantidade'];
            $total += $subtotal;

            $venda->produtos()->attach($produto->id, [
                'quantidade' => $produtoData['quantidade'],
                'preco_unitario' => $produto->preco
            ]);
        }

        $venda->update([
            'cliente_id' => $request->cliente_id,
            'total' => $total
        ]);
        
        LogHelper::log('Atualizou venda', 'Venda', $venda->id, 'Cliente ID: ' . $venda->cliente_id . ', Novo Total: R$ ' . number_format($venda->total, 2, ',', '.'));

        return redirect()->route('vendas.index')->with('success', 'Venda atualizada com sucesso!');
    }

   
    public function destroy(string $id){
        $venda = Venda::with('produtos')->findOrFail($id);

        if (auth()->user()->role !== 'admin' && $venda->user_id !== auth()->id()) {
            abort(403, 'Acesso não autorizado.');
        }

        foreach ($venda->produtos as $produto) {
            $produto->estoque += $produto->pivot->quantidade;
            $produto->save();
            }

            $venda->delete();

            LogHelper::log('Excluiu venda', 'Venda', $venda->id, 'Cliente ID: ' . $venda->cliente_id . ', Total: R$ ' . number_format($venda->total, 2, ',', '.'));

            return redirect()->route('vendas.index')->with('success', 'Venda excluída com sucesso!');
        }
    }
