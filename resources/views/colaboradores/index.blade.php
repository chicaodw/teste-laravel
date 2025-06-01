@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-people-fill me-2"></i> Colaboradores
        </h2>
        <a href="{{ route('colaboradores.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Novo Colaborador
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Perfil</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($colaboradores as $colaborador)
                        <tr>
                            <td>{{ $colaborador->name }}</td>
                            <td>{{ $colaborador->email }}</td>
                            <td>{{ $colaborador->telefone ?? '—' }}</td>
                            <td>
                                @if ($colaborador->role === 'admin')
                                    <span class="badge bg-primary">Administrador</span>
                                @else
                                    <span class="badge bg-secondary">Vendedor</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('colaboradores.edit', $colaborador->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal"
                                    data-id="{{ $colaborador->id }}"
                                    data-nome="{{ $colaborador->name }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Nenhum colaborador cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Exclusão</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          Tem certeza que deseja excluir o colaborador <strong id="colaboradorNome"></strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Sim, excluir</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('confirmDeleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const colaboradorId = button.getAttribute('data-id');
        const colaboradorNome = button.getAttribute('data-nome');

        const form = deleteModal.querySelector('#deleteForm');
        form.action = `/colaboradores/${colaboradorId}`;
        deleteModal.querySelector('#colaboradorNome').textContent = colaboradorNome;
    });
});
</script>
@endpush
