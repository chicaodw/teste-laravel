<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-900 px-4">
        <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-lg p-8 text-white">
            <div class="text-center mb-6">
                <x-authentication-card-logo  class="mx-auto" />
                <h2 class="mt-4 text-2xl font-bold">Bem-vindo de volta</h2>
                <p class="text-gray-400 text-sm">Faça login para continuar</p>
            </div>

            <x-validation-errors class="mb-4 text-sm text-red-400" />

            @if (session('status'))
                <div class="mb-4 text-green-400 text-sm text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm mb-1">Email</label>
                    <input id="email" name="email" type="email" required autofocus
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ old('email') }}">
                </div>

                <!-- Senha -->
                <div>
                    <label for="password" class="block text-sm mb-1">Senha</label>
                    <input id="password" name="password" type="password" required
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Lembrar-me + Esqueceu senha -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="form-checkbox text-indigo-500 bg-gray-700 border-gray-600 rounded" />
                        <span class="text-gray-300">Lembrar-me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-indigo-400 hover:text-indigo-300">
                            Esqueceu a senha?
                        </a>
                    @endif
                </div>

                <!-- Botão -->
                <div>
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 transition-all text-white py-2 px-4 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
