@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Vendas</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4"><i class="bi bi-cart"></i> Vendas</h1>
        <a href="{{ route('vendas.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Nova Venda
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    @if(auth()->user()->role === 'admin')
                        <th>Vendedor</th>
                    @endif
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Data</th>
                    <th style="width: 180px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vendas as $venda)
                    <tr>
                        <td>{{ $venda->id }}</td>
                        @if(auth()->user()->role === 'admin')
                            <td>{{ $venda->user->name ?? '—' }}</td>
                        @endif
                        <td>{{ $venda->cliente->nome }}</td>
                        <td>R$ {{ number_format($venda->total, 2, ',', '.') }}</td>
                        <td>{{ $venda->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('vendas.show', $venda->id) }}" class="btn btn-sm btn-outline-info me-1">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('vendas.edit', $venda->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal"
                                data-id="{{ $venda->id }}"
                                data-cliente="{{ $venda->cliente->nome }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma venda registrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
          Tem certeza que deseja excluir a venda para o cliente <strong id="clienteNome"></strong>?
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
        const vendaId = button.getAttribute('data-id');
        const clienteNome = button.getAttribute('data-cliente');

        const form = deleteModal.querySelector('#deleteForm');
        form.action = `/vendas/${vendaId}`;
        deleteModal.querySelector('#clienteNome').textContent = clienteNome;
    });
});
</script>
@endpush
