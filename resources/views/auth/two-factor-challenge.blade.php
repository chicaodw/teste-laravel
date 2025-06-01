<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-900 px-4">
        <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-lg p-8 text-white">
            <div class="text-center mb-6">
                <x-authentication-card-logo class="mx-auto" />
                <h2 class="mt-4 text-2xl font-bold">Autenticação em Duas Etapas</h2>
                <p class="text-gray-400 text-sm">Confirme o acesso com o código do aplicativo ou código de recuperação.</p>
            </div>

            <div x-data="{ recovery: false }">
                <div class="mb-4 text-sm text-gray-400" x-show="!recovery">
                    {{ __('Digite o código gerado pelo seu aplicativo autenticador.') }}
                </div>

                <div class="mb-4 text-sm text-gray-400" x-show="recovery" x-cloak>
                    {{ __('Digite um dos seus códigos de recuperação de emergência.') }}
                </div>

                <x-validation-errors class="mb-4 text-sm text-red-400" />

                <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-5">
                    @csrf

                    <div x-show="!recovery">
                        <label for="code" class="block text-sm mb-1">Código de Autenticação</label>
                        <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code" x-ref="code"
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>

                    <div x-show="recovery" x-cloak>
                        <label for="recovery_code" class="block text-sm mb-1">Código de Recuperação</label>
                        <input id="recovery_code" name="recovery_code" type="text" autocomplete="one-time-code" x-ref="recovery_code"
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <button type="button"
                            class="text-indigo-400 hover:text-indigo-300 underline"
                            x-show="!recovery"
                            x-on:click="
                                recovery = true;
                                $nextTick(() => { $refs.recovery_code.focus() })
                            ">
                            Usar código de recuperação
                        </button>

                        <button type="button"
                            class="text-indigo-400 hover:text-indigo-300 underline"
                            x-show="recovery"
                            x-cloak
                            x-on:click="
                                recovery = false;
                                $nextTick(() => { $refs.code.focus() })
                            ">
                            Usar código do aplicativo
                        </button>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 transition-all text-white py-2 px-4 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Entrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
