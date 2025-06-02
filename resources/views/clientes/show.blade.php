@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('clientes.index') }}">Clientes</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-person-circle me-2"></i> {{ $cliente->nome }}
            </h5>
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-light btn-sm">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
        </div>

        <div class="card-body">
            <p class="mb-2"><strong><i class="bi bi-envelope me-1"></i>Email:</strong> {{ $cliente->email }}</p>
            <p class="mb-0"><strong><i class="bi bi-telephone me-1"></i>Telefone:</strong> {{ $cliente->telefone }}</p>
        </div>
    </div>

    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary mt-4">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>
@endsection
