<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-900 px-4">
        <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-lg p-8 text-white">
            <div class="text-center mb-6">
                <x-authentication-card-logo class="mx-auto" />
                <h2 class="mt-4 text-2xl font-bold">Verifique seu e-mail</h2>
                <p class="text-gray-400 text-sm mt-2">
                    Antes de continuar, verifique seu endereço de e-mail clicando no link que enviamos. <br>
                    Se não recebeu, podemos enviar outro.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-green-400 text-sm text-center">
                    Um novo link de verificação foi enviado para seu e-mail.
                </div>
            @endif

            <div class="space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 transition-all text-white py-2 px-4 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Reenviar e-mail de verificação
                    </button>
                </form>

                <div class="flex justify-between items-center text-sm">
                    <a href="{{ route('profile.show') }}" class="text-indigo-400 hover:text-indigo-300 underline">
                        Editar perfil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-indigo-400 hover:text-indigo-300 underline">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
