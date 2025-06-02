<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Helpers\LogHelper;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required',
            'estoque' => 'required|integer',
            'descricao' => 'required',
            'imagem_cortada' => 'nullable|string',
        ]);

        $dados = $request->except('imagem_cortada');
        $dados['preco'] = str_replace(['.', ','], ['', '.'], $request->input('preco'));

        if ($request->filled('imagem_cortada')) {
            $base64 = $request->input('imagem_cortada');
            if (str_contains($base64, ';base64,')) {
                $image_parts = explode(";base64,", $base64);
                $image_base64 = base64_decode($image_parts[1]);

                $fileName = uniqid() . '.jpg';
                $path = public_path('uploads/produtos/' . $fileName);

                if (!file_exists(dirname($path))) {
                    mkdir(dirname($path), 0755, true);
                }

                file_put_contents($path, $image_base64);
                $dados['imagem'] = 'uploads/produtos/' . $fileName;
            }
        }

        $produto = Produto::create($dados);
        
        LogHelper::log('Criou produto', 'Produto', $produto->id, 'Nome: ' . $produto->nome);

        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
    }

    public function show(string $id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.show', compact('produto'));
    }

    public function edit(string $id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required',
            'estoque' => 'required|integer',
            'imagem_cortada' => 'nullable|string',
        ]);

        $produto = Produto::findOrFail($id);

        $dados = $request->except('imagem_cortada');
        $dados['preco'] = str_replace(['.', ','], ['', '.'], $request->input('preco'));

        if ($request->filled('imagem_cortada')) {
            if ($produto->imagem && file_exists(public_path($produto->imagem))) {
                unlink(public_path($produto->imagem));
            }

            $base64 = $request->input('imagem_cortada');
            if (str_contains($base64, ';base64,')) {
                $image_parts = explode(";base64,", $base64);
                $image_base64 = base64_decode($image_parts[1]);

                $fileName = uniqid() . '.jpg';
                $path = public_path('uploads/produtos/' . $fileName);

                if (!file_exists(dirname($path))) {
                    mkdir(dirname($path), 0755, true);
                }

                file_put_contents($path, $image_base64);
                $dados['imagem'] = 'uploads/produtos/' . $fileName;
            }
        }

        $produto->update($dados);
        LogHelper::log('Atualizou produto', 'Produto', $produto->id, 'Nome: ' . $produto->nome);
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $produto = Produto::findOrFail($id);

        if ($produto->imagem && file_exists(public_path($produto->imagem))) {
            unlink(public_path($produto->imagem));
        }

        $produto->delete();
        LogHelper::log('Excluiu produto', 'Produto', $produto->id, 'Nome: ' . $produto->nome);
        return redirect()->route('produtos.index')->with('success', 'Produto removido com sucesso!');
    }
}
