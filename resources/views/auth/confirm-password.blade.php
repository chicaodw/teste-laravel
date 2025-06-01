<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-900 px-4">
        <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-lg p-8 text-white">
            <div class="text-center mb-6">
                <x-authentication-card-logo class="mx-auto" />
                <h2 class="mt-4 text-2xl font-bold">Confirme sua Senha</h2>
                <p class="text-gray-400 text-sm">
                    Esta é uma área segura da aplicação. Por favor, confirme sua senha antes de continuar.
                </p>
            </div>

            <x-validation-errors class="mb-4 text-sm text-red-400" />

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                @csrf

                <!-- Campo de senha -->
                <div>
                    <label for="password" class="block text-sm mb-1">Senha</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>

                <!-- Botão -->
                <div>
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 transition-all text-white py-2 px-4 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
