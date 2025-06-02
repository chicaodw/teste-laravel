<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Helpers\LogHelper;

class ColaboradorController extends Controller
{
    /**
     * Lista todos os colaboradores (exceto clientes).
     */
    public function index()
    {
        $colaboradores = User::where('role', '!=', 'cliente')->get();
        return view('colaboradores.index', compact('colaboradores'));
    }

    /**
     * Mostra o formulário de criação de colaborador.
     */
    public function create()
    {
        return view('colaboradores.create');
    }

    /**
     * Salva um novo colaborador e envia e-mail para definição de senha.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'telefone' => 'nullable|string',
            'role'     => 'required|in:admin,vendedor,financeiro',
        ]);

        $password = Str::random(10);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'telefone' => $request->telefone,
            'role'     => $request->role,
            'password' => bcrypt($password),
        ]);

        // Envia link de redefinição de senha para o e-mail
        Password::sendResetLink(['email' => $user->email]);

        // Log de criação
        LogHelper::log(
            'Criou colaborador',
            'User',
            $user->id,
            'Nome: ' . $user->name . ', Email: ' . $user->email . ', Perfil: ' . $user->role
        );

        return redirect()
            ->route('colaboradores.index')
            ->with('success', 'Colaborador criado com sucesso. Um link foi enviado para o e-mail para definição da senha.');
    }

    /**
     * Exibe os detalhes de um colaborador.
     */
    public function show(string $id)
    {
        $colaborador = User::findOrFail($id);
        return view('colaboradores.show', compact('colaborador'));
    }

    /**
     * Mostra o formulário de edição.
     */
    public function edit(string $id)
    {
        $colaborador = User::findOrFail($id);
        return view('colaboradores.edit', compact('colaborador'));
    }

    /**
     * Atualiza os dados do colaborador.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => "required|email|unique:users,email,$id",
            'telefone' => 'nullable|string',
            'role'     => 'required|in:admin,vendedor,financeiro',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'telefone' => $request->telefone,
            'role'     => $request->role,
        ]);

        LogHelper::log(
            'Editou colaborador',
            'User',
            $user->id,
            'Nome: ' . $user->name . ', Email: ' . $user->email . ', Perfil: ' . $user->role
        );

        return redirect()
            ->route('colaboradores.index')
            ->with('success', 'Colaborador atualizado com sucesso.');
    }

    /**
     * Remove o colaborador, exceto se for o próprio usuário logado.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return redirect()
                ->route('colaboradores.index')
                ->with('error', 'Você não pode excluir a si mesmo.');
        }

        $user->delete();

        LogHelper::log(
            'Removeu colaborador',
            'User',
            $user->id,
            'Nome: ' . $user->name . ', Email: ' . $user->email . ', Perfil: ' . $user->role
        );

        return redirect()
            ->route('colaboradores.index')
            ->with('success', 'Colaborador excluído com sucesso.');
    }
}
