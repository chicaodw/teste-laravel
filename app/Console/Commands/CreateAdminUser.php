<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria o primeiro usuário administrador do sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Nome do administrador');
        $email = $this->ask('Email');
        $password = $this->secret('Senha');

        if (User::where('email', $email)->exists()) {
            $this->error("Já existe um usuário com esse email.");
            return 1;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info("Usuário administrador criado com sucesso: {$user->email}");
        return 0;
    }
    
}
