<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema de Vendas') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts do Vite e Livewire -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @stack('styles')

    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #343a40;
            transition: width 0.3s;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar .nav-link {
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed h5 {
            display: none !important;
        }

        .sidebar .nav-link:hover {
            background-color: #495057;
        }

        .sidebar .nav-link.active {
            background-color: #198754;
            font-weight: bold;
        }

        .toggle-sidebar-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.25rem;
        }

        .sidebar.collapsed .nav-link {
            text-align: center;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        .sidebar-toggle-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

       
        .sidebar.collapsed .btn span {
            display: none !important;
        }



        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .sidebar.show {
                display: block;
                position: absolute;
                z-index: 1000;
            }

            .sidebar-toggle-wrapper {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- NAV MOBILE -->
    <nav class="navbar navbar-dark bg-dark d-md-none px-3">
        <button class="toggle-sidebar-btn" onclick="toggleSidebar()" aria-label="Abrir menu">
            <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand mb-0 h6">Sistema de Vendas</span>
    </nav>

    <div class="d-flex">
        <!-- SIDEBAR -->
        <aside id="sidebar" class="sidebar p-3 d-md-block" style="display: none;" aria-label="Menu lateral">
            <div class="sidebar-toggle-wrapper">
                <h5 class="text-white mb-0 d-none d-md-block">Sistema de Vendas</h5>
                <button class="toggle-sidebar-btn d-none d-md-inline" onclick="toggleSidebar()" aria-label="Reduzir menu">
                    <i id="collapse-icon" class="bi bi-chevron-double-left"></i>
                </button>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i> <span>Dashboard</span>
                    </a>
                </li>
                @auth
                    @if (auth()->user()->role === 'admin')
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                                <i class="bi bi-people me-2"></i> <span>Clientes</span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('colaboradores.*') ? 'active' : '' }}" href="{{ route('colaboradores.index') }}">
                                <i class="bi bi-person-gear me-2"></i> <span>Colaboradores</span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('produtos.*') ? 'active' : '' }}" href="{{ route('produtos.index') }}">
                                <i class="bi bi-box-seam me-2"></i> <span>Produtos</span>
                            </a>
                        </li>
                    @endif
                    @if (in_array(auth()->user()->role, ['admin', 'vendedor']))
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('vendas.*') ? 'active' : '' }}" href="{{ route('vendas.index') }}">
                                <i class="bi bi-cart me-2"></i> <span>Vendas</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->role === 'admin')
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('logs.*') ? 'active' : '' }}" href="{{ route('logs.index') }}">
                                <i class="bi bi-clock-history me-2"></i> <span>Logs</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item mt-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-light btn-sm w-100 text-start">
                                <i class="bi bi-box-arrow-right me-2"></i> <span>Sair</span>
                            </button>
                         </form>
                    </li>
                @endauth
            </ul>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <div class="flex-grow-1 p-4">
            @if (isset($header))
                <div class="alert alert-secondary mb-3">
                    {{ $header }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            @endif

            <main>
                @yield('content')
            </main>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- JS EXTRAS -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('collapse-icon');

            if (window.innerWidth < 768) {
                sidebar.classList.toggle('show');
                sidebar.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
            } else {
                const isCollapsed = sidebar.classList.toggle('collapsed');
                icon.classList.toggle('bi-chevron-double-left', !isCollapsed);
                icon.classList.toggle('bi-chevron-double-right', isCollapsed);
                localStorage.setItem('sidebar-collapsed', isCollapsed ? 'true' : 'false');
            }
        }

        document.addEventListener('click', function (event) {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                if (!sidebar.contains(event.target) && !event.target.closest('.toggle-sidebar-btn')) {
                    sidebar.classList.remove('show');
                    sidebar.style.display = 'none';
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('collapse-icon');
            const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';

            if (window.innerWidth >= 768) {
                sidebar.style.display = 'block';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    icon.classList.remove('bi-chevron-double-left');
                    icon.classList.add('bi-chevron-double-right');
                }
            }
        });
    </script>
     @stack('scripts')
</body>
</html>
