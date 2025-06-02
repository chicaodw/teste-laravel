@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-receipt"></i> Detalhes da Venda #{{ $venda->id }}</h5>
        </div>
        <div class="card-body">
            <p class="mb-1"><strong><i class="bi bi-person"></i> Cliente:</strong> {{ $venda->cliente->nome }}</p>
            <p class="mb-1"><strong><i class="bi bi-calendar-event"></i> Data:</strong> {{ $venda->created_at->format('d/m/Y H:i') }}</p>
            <p class="mb-3"><strong><i class="bi bi-cash-coin"></i> Total:</strong> R$ {{ number_format($venda->total, 2, ',', '.') }}</p>

            <h5 class="mb-3">Produtos</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Imagem</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Preço Unitário</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($venda->produtos as $produto)
                            <tr>
                                <td style="width: 60px;">
                                    @if ($produto->imagem)
                                        <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}" class="img-thumbnail" width="50">
                                    @else
                                        <span class="text-muted small">Sem imagem</span>
                                    @endif
                                </td>
                                <td>{{ $produto->nome }}</td>
                                <td>{{ $produto->pivot->quantidade }}</td>
                                <td>R$ {{ number_format($produto->pivot->preco_unitario, 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($produto->pivot->preco_unitario * $produto->pivot->quantidade, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-3">
                <a href="{{ route('vendas.index') }}" class="btn btn-outline-secondary mt-3">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            <div>
        </div>
    </div>
</div>
@endsection
