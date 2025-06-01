<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Helpers\LogHelper;

class ClienteController extends Controller{
   
    public function index(){
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create(){
        return view('clientes.create');
    }

    public function store(Request $request){
         $request->validate([
            'nome' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', 'unique:clientes,email'],
            'telefone' => 'required|string|max:20',
        ], [
        'email.unique' => 'Este e-mail já está cadastrado.',
        'email.required' => 'O campo e-mail é obrigatório.',
        'nome.required' => 'O campo nome é obrigatório.',
        'telefone.required' => 'O campo telefone é obrigatório.',
    ]);

        $cliente = Cliente::create($request->all());

        LogHelper::log('Criou cliente', 'Cliente', $cliente->id, 'Nome: ' . $cliente->nome);

        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
    }

    public function show(string $id){
        $cliente = Cliente::findOrFail($id);
        return view('clientes.show', compact('cliente'));
    }

    public function edit(string $id){   
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());
        LogHelper::log('Atualizou cliente', 'Cliente', $cliente->id, 'Nome: ' . $cliente->nome);
        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(string $id){
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        LogHelper::log('Excluiu cliente', 'Cliente', $cliente->id, 'Nome: ' . $cliente->nome);
        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }
}