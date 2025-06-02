@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-box-seam"></i> Produtos</h2>
        <a href="{{ route('produtos.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Novo Produto
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Descrição</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produtos as $produto)
                        <tr>
                            <td style="width: 80px;">
                                @if ($produto->imagem)
                                    <img src="{{ asset($produto->imagem) }}" alt="Imagem do Produto" class="img-thumbnail" style="height: 60px; width: 60px; object-fit: cover;">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $produto->nome }}</td>
                            <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                            <td>{{ $produto->estoque }}</td>
                            <td>{{ $produto->descricao }}</td>
                            <td class="text-center">
                                <a href="{{ route('produtos.show', $produto) }}" class="btn btn-sm btn-outline-primary" title="Ver detalhes">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-sm btn-outline-warning" title="Editar produto">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal"
                                    data-id="{{ $produto->id }}"
                                    data-nome="{{ $produto->nome }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Nenhum produto cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

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
          Tem certeza que deseja excluir o produto <strong id="produtoNome"></strong>?
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
        const produtoId = button.getAttribute('data-id');
        const produtoNome = button.getAttribute('data-nome');

        const form = deleteModal.querySelector('#deleteForm');
        form.action = `/produtos/${produtoId}`;
        deleteModal.querySelector('#produtoNome').textContent = produtoNome;
    });
});
</script>
@endpush
