@extends('layouts.app')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('colaboradores.index') }}">Colaboradores</a>
            </li>
            <li class="breadcrumb-item active">Editar Colaborador</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Editar Colaborador</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('colaboradores.update', $colaborador->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">
                        <i class="bi bi-person-fill me-1 text-primary"></i> Nome <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name', $colaborador->name) }}"
                           required
                           placeholder="Digite o nome completo">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">
                        <i class="bi bi-envelope-fill me-1 text-primary"></i> Email <span class="text-danger">*</span>
                    </label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           value="{{ old('email', $colaborador->email) }}"
                           required
                           placeholder="exemplo@email.com"
                           title="Digite um e-mail válido. Ex: exemplo@dominio.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label fw-semibold">
                        <i class="bi bi-telephone-fill me-1 text-primary"></i> Telefone <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('telefone') is-invalid @enderror"
                           id="telefone"
                           name="telefone"
                           value="{{ old('telefone', $colaborador->telefone) }}"
                           maxlength="15"
                           required
                           placeholder="(99) 99999-9999">
                    @error('telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label fw-semibold">
                        <i class="bi bi-person-gear me-1 text-primary"></i> Perfil <span class="text-danger">*</span>
                    </label>
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="">Selecione o perfil</option>
                        <option value="admin" {{ old('role', $colaborador->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="vendedor" {{ old('role', $colaborador->role) === 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('colaboradores.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle me-1"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
