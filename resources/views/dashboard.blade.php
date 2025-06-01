@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Indicadores (KPIs) --}}
    <h4 class="mb-4">Indicadores Gerais</h4>

    @php
        $isAdmin = Auth::user()->role === 'admin';
    @endphp

    @if ($isAdmin)
        {{-- Indicadores (KPIs) --}}
        <h4 class="mb-4">Indicadores Gerais</h4>
        <div class="row row-cols-1 row-cols-md-5 g-3 text-center mb-4">
            <x-kpi-card titulo="Clientes" valor="{{ $totalClientes }}" icone="bi-people-fill" cor="primary"/>
            <x-kpi-card titulo="Produtos" valor="{{ $totalProdutos }}" icone="bi-box-seam" cor="info"/>
            <x-kpi-card titulo="Colaboradores" valor="{{ $totalColaboradores ?? 0 }}" icone="bi-person-badge" cor="secondary"/>
            <x-kpi-card titulo="Vendas" valor="{{ $totalVendas }}" icone="bi-cart" cor="success"/>
            <x-kpi-card titulo="Faturamento" valor="R$ {{ number_format($faturamento, 2, ',', '.') }}" icone="bi-currency-dollar" cor="warning"/>
        </div>
    @else
        {{-- Indicadores para vendedor --}}
        <h4 class="mb-4">Seus Indicadores</h4>
        <div class="row row-cols-1 row-cols-md-3 g-3 text-center mb-4">
            <x-kpi-card titulo="Vendas" valor="{{ $totalVendas }}" icone="bi-cart" cor="success"/>
            <x-kpi-card titulo="Faturamento" valor="R$ {{ number_format($faturamento, 2, ',', '.') }}" icone="bi-currency-dollar" cor="warning"/>
            <x-kpi-card titulo="Ticket Médio" valor="R$ {{ number_format($ticketMedio, 2, ',', '.') }}" icone="bi-bar-chart" cor="info"/>
        </div>
    @endif

    {{-- Gráficos --}}
    <h4 class="mb-3">Gráficos</h4>
    <div class="row">
        {{-- Vendas Mensais --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-graph-up"></i> Vendas Mensais
                </div>
                <div class="card-body">
                    <canvas id="vendasChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Produtos Mais Vendidos --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-pie-chart-fill"></i> Produtos Mais Vendidos
                </div>
                <div class="card-body">
                    <canvas id="produtosChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @isset($colaboradores)
    {{-- Gráfico de vendas por colaborador --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-secondary text-white">
                    <i class="bi bi-people"></i> Vendas por Colaborador
                </div>
                <div class="card-body">
                    <canvas id="colaboradoresChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Estoque Atual --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-boxes"></i> Estoque Atual
                </div>
                <div class="card-body" style="overflow-x: auto;">
                    <canvas id="estoqueChart" style="max-width: 100%; height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
      {{-- Clientes por mês --}}
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-person-plus-fill"></i> Novos Clientes por Mês
                </div>
                <div class="card-body">
                    <canvas id="clientesMesChart"></canvas>
                </div>
            </div>
        </div>
    @endisset

</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dados vindos do backend
    const meses = @json($meses);
    const valoresMensais = @json($valoresMensais);
    const produtosNomes = @json($produtosNomes);
    const produtosQuantidades = @json($produtosQuantidades);
    const colaboradores = @json($colaboradores ?? []);
    const vendasPorColaborador = @json($vendasPorColaborador ?? []);
    const nomesEstoque = @json($nomesEstoque ?? []);
    const quantidadesEstoque = @json($quantidadesEstoque ?? []);
    const clientesPorMesLabels = @json($clientesPorMesLabels ?? []);
    const clientesPorMesValues = @json($clientesPorMesValues ?? []);

    // Gráfico de Vendas Mensais
    const ctxVendas = document.getElementById('vendasChart')?.getContext('2d');
    if (ctxVendas) {
        new Chart(ctxVendas, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Total de Vendas',
                    data: valoresMensais,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
    }

    // Produtos Mais Vendidos
    const ctxProdutos = document.getElementById('produtosChart')?.getContext('2d');
    if (ctxProdutos) {
        new Chart(ctxProdutos, {
            type: 'pie',
            data: {
                labels: produtosNomes,
                datasets: [{
                    label: 'Quantidade Vendida',
                    data: produtosQuantidades,
                    backgroundColor: [
                        '#36A2EB', '#4BC0C0', '#FFCE56', '#FF6384', '#9966FF'
                    ]
                }]
            },
            options: { responsive: true }
        });
    }

    // Vendas por Colaborador
    const ctxColab = document.getElementById('colaboradoresChart')?.getContext('2d');
    if (ctxColab) {
        new Chart(ctxColab, {
            type: 'bar',
            data: {
                labels: colaboradores,
                datasets: [{
                    label: 'Total de Vendas',
                    data: vendasPorColaborador,
                    backgroundColor: 'rgba(153, 102, 255, 0.6)'
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
    }

    // Estoque Atual
    const ctxEstoque = document.getElementById('estoqueChart')?.getContext('2d');
    if (ctxEstoque) {
        new Chart(ctxEstoque, {
            type: 'bar',
            data: {
                labels: nomesEstoque,
                datasets: [{
                    label: 'Estoque',
                    data: quantidadesEstoque,
                    backgroundColor: 'rgba(255, 206, 86, 0.6)'
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y', // ← isso transforma o gráfico em horizontal
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Clientes por Mês
    const ctxClientes = document.getElementById('clientesMesChart')?.getContext('2d');
    if (ctxClientes) {
        new Chart(ctxClientes, {
            type: 'line',
            data: {
                labels: clientesPorMesLabels,
                datasets: [{
                    label: 'Novos Clientes',
                    data: clientesPorMesValues,
                    backgroundColor: 'rgba(75, 192, 192, 0.4)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
    }
});
</script>
@endpush
