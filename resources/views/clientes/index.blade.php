@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Clientes</h2>
        <a href="{{ route('clientes.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Novo Cliente
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th scope="col" class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->telefone }}</td>
                            <td class="text-end">
                                <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal"
                                    data-id="{{ $cliente->id }}"
                                    data-nome="{{ $cliente->nome }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Nenhum cliente cadastrado ainda.</td>
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
          Tem certeza que deseja excluir o cliente <strong id="clienteNome"></strong>?
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
        const clienteId = button.getAttribute('data-id');
        const clienteNome = button.getAttribute('data-nome');

        const form = deleteModal.querySelector('#deleteForm');
        form.action = `/clientes/${clienteId}`;
        deleteModal.querySelector('#clienteNome').textContent = clienteNome;
    });
});
</script>
@endpush
