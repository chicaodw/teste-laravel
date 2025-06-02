<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-900 px-4">
        <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-lg p-8 text-white">
            <div class="text-center mb-6">
                <x-authentication-card-logo class="mx-auto" />
                <h2 class="mt-4 text-2xl font-bold">Redefinir Senha</h2>
                <p class="text-gray-400 text-sm">Informe sua nova senha abaixo.</p>
            </div>

            <x-validation-errors class="mb-4 text-sm text-red-400" />

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm mb-1">Email</label>
                    <input id="email" type="email" name="email"
                        value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>

                <!-- Nova senha -->
                <div>
                    <label for="password" class="block text-sm mb-1">Nova Senha</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>

                <!-- Confirmar senha -->
                <div>
                    <label for="password_confirmation" class="block text-sm mb-1">Confirme a Senha</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>

                <!-- Botão -->
                <div>
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 transition-all text-white py-2 px-4 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Redefinir Senha
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
