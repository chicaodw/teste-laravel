# Sistema de Gerenciamento de Vendas | Laravel 10 + PHP 8.1

Este é um projeto desenvolvido como parte do teste técnico Laravel do Grupo DDM. O sistema permite o gerenciamento de clientes, produtos e vendas, com funcionalidades específicas para administradores e vendedores.

## Tecnologias Utilizadas

-   PHP 8.1
-   Laravel 10
-   MySQL
-   Bootstrap 5
-   Chart.js
-   Mail (SMTP via Brevo)

## Funcionalidades

-   Autenticação com perfis: Admin e Vendedor
-   Cadastro, edição, listagem e exclusão de Clientes, Produtos e Vendas
-   Dashboard com indicadores globais (Admin) e individuais (Vendedor)
-   Logs de atividade do sistema
-   Cadastro de colaboradores com envio automático de senha por e-mail

## Configuração do Projeto

### 1. Clonar o repositório

```bash
git clone https://github.com/grupo-ddm/teste-laravel.git
cd teste-laravel
```

### 2. Mude para a branch do teste

```bash
git checkout francisco_costa_99984289317
```

### 3. Instalar dependências

```bash
composer install
npm install && npm run build
```

### 4. Configurar o `.env`

Copie o arquivo de exemplo e configure:

```bash
cp .env.example .env
php artisan key:generate
```

Atualize o `.env` com as configurações do banco de dados e do e-mail:

```
DB_DATABASE=seubanco
DB_USERNAME=usuario
DB_PASSWORD=senha

MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@dominio.com
MAIL_PASSWORD=sua_senha_smtp_gerada
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu_email@dominio.com
MAIL_FROM_NAME="Sistema de Vendas"
```

### 5. Rodar o servidor

```bash
php artisan serve
```

Acesse: [http://127.0.0.1:8000](http://127.0.0.1:8000)

### 5. Rodar o npm

```bash
npm run dev
```

Acesse: [http://localhost:5173/](http://localhost:5173/)

## Criar o primeiro usuário via CLI (Admin)

Criar manualmente o primeiro usuário administrador com o comando:

```bash
php artisan create:admin-user
```

Esse comando solicitará:

-   Nome do administrador
-   E-mail
-   Senha (oculta no terminal)

Após isso, criará o usuário com a role `admin`, desde que o e-mail não esteja já cadastrado.

## Configurando o SMTP na Brevo

1. Acesse [https://www.brevo.com](https://www.brevo.com) e crie uma conta gratuita
2. Após login, vá em [Configurações SMTP](https://app.brevo.com/settings/keys/smtp)
3. Copie o servidor SMTP: `smtp-relay.brevo.com`
4. Crie uma nova chave SMTP:

    - Vá em "SMTP & API"
    - Clique em "Criar uma nova chave SMTP"
    - Nomeie e salve a chave (ela só aparecerá uma vez!)

5. Configure seu `.env` conforme a chave e e-mail usado

> Importante: guarde a chave SMTP com segurança. Nunca compartilhe publicamente.

## Estrutura do Banco

As principais tabelas utilizadas são:

-   `clientes` (id, nome, email, telefone, created_at, updated_at)
-   `produtos` (id, nome, preco, estoque, descricao, created_at, updated_at, imagem.)
-   `vendas` (id, cliente_id, total, data, created_at, updated_at, user_id)
-   `users` (id, name, email, email_verified_at, password, role \[admin|vendedor])
-   `produto_venda` (pivot com venda_id, produto_id, quantidade, preco_unitario, created_at,updated_at )
-   `logs` (id, user_id, action, model_id, descriptio, ip, created_at, updated_at )

