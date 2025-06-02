@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('produtos.index') }}">Produtos</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-box-seam me-2"></i> {{ $produto->nome }}
            </h5>
            <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-light btn-sm">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
        </div>

        <div class="card-body">
            @if (!empty($produto->imagem))
                <div class="text-center mb-4">
                    <img src="{{ asset($produto->imagem) }}" alt="Imagem do Produto" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                </div>
            @endif

            <p class="mb-2"><strong><i class="bi bi-currency-dollar me-1"></i>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
            <p class="mb-2"><strong><i class="bi bi-stack me-1"></i>Estoque:</strong> {{ $produto->estoque }}</p>
            <p class="mb-0"><strong><i class="bi bi-card-text me-1"></i>Descrição:</strong> {{ $produto->descricao }}</p>
        </div>
    </div>

    <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary mt-4">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>
@endsection
