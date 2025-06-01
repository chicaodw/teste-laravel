@extends('layouts.app')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('colaboradores.index') }}">Colaboradores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0"><i class="bi bi-person-badge me-2"></i> Detalhes do Colaborador</h4>
        </div>
        <div class="card-body">
            <p><strong>Nome:</strong> {{ $colaborador->name }}</p>
            <p><strong>Email:</strong> {{ $colaborador->email }}</p>
            <p><strong>Telefone:</strong> {{ $colaborador->telefone ?? '—' }}</p>
            <p><strong>Perfil:</strong>
                @if ($colaborador->role === 'admin')
                    <span class="badge bg-primary">Administrador</span>
                @else
                    <span class="badge bg-secondary">Vendedor</span>
                @endif
            </p>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('colaboradores.edit', $colaborador->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="{{ route('colaboradores.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
