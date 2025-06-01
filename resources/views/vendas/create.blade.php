@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('vendas.index') }}">Vendas</a>
            </li>
            <li class="breadcrumb-item active">Nova Venda</li>
        </ol>
    </nav>

    <form action="{{ route('vendas.store') }}" method="POST" id="form-venda">
        @csrf

        <div class="mb-4">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required></select>
        </div>

        <div class="mb-4">
            <label for="produto_select" class="form-label">Adicionar Produto</label>
            <select id="produto_select" class="form-select">
                <option value="">Digite para buscar produtos...</option>
            </select>
        </div>

        <h5>Produtos Selecionados</h5>
        <table class="table table-bordered" id="produtos_selecionados">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Imagem</th>
                    <th>Preço</th>
                    <th>Qtd</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <h5 class="mt-3">Total da Venda: <span id="totalVenda" class="text-success fw-bold">R$ 0,00</span></h5>

        <button type="submit" class="btn btn-success mt-4">
            <i class="bi bi-save me-1"></i> Salvar Venda
        </button>
    </form>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const produtosSelecionados = new Map();
    const tbody = document.querySelector('#produtos_selecionados tbody');
    const totalSpan = document.getElementById('totalVenda');

    $('#cliente_id').select2({
        width: '100%',
        placeholder: 'Busque um cliente...',
        ajax: {
            url: '{{ route("api.clientes") }}',
            dataType: 'json',
            delay: 250,
            processResults: data => ({
                results: data.map(cliente => ({
                    id: cliente.id,
                    text: cliente.nome
                }))
            }),
        }
    });

    $('#produto_select').select2({
        width: '100%',
        placeholder: 'Buscar produto...',
        ajax: {
            url: '{{ route("api.produtos") }}',
            dataType: 'json',
            delay: 250,
            processResults: data => ({
                results: data.map(produto => ({
                    id: produto.id,
                    text: produto.estoque > 0
                    ? `${produto.nome} - R$ ${parseFloat(produto.preco).toFixed(2)}`
                    : `${produto.nome} - SEM ESTOQUE`,
                    nome: produto.nome,
                    preco: produto.preco,
                    estoque: produto.estoque,
                    imagem: produto.imagem
                }))
            }),
        }
    });

    $('#produto_select').on('select2:select', function (e) {
        const data = e.params.data;

        if (produtosSelecionados.has(data.id)) {
            alert('Produto já adicionado.');
            return;
        }

        produtosSelecionados.set(data.id, data);

        const row = document.createElement('tr');
        row.dataset.produtoId = data.id;
        row.innerHTML = `
            <td>
                ${data.nome}
            </td>
            <td>
                ${data.imagem ? `<img src="${data.imagem}" alt="${data.nome}" width="40" class="me-2 rounded">` : ''}
            </td>
            <td>R$ ${parseFloat(data.preco).toFixed(2)}</td>
            <td>
                <input type="number" name="produtos[${data.id}][quantidade]" value="1" min="1" max="${data.estoque}" class="form-control quantidade">
                <input type="hidden" name="produtos[${data.id}][id]" value="${data.id}">
            </td>
            <td class="total-produto">R$ ${parseFloat(data.preco).toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remover-produto">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;


        tbody.appendChild(row);
        atualizarTotal();
    });

    tbody.addEventListener('input', function (e) {
        if (e.target.classList.contains('quantidade')) {
            const tr = e.target.closest('tr');
            const preco = parseFloat(produtosSelecionados.get(parseInt(tr.dataset.produtoId)).preco);
            const qtd = parseInt(e.target.value) || 0;
            const totalProduto = preco * qtd;
            tr.querySelector('.total-produto').textContent = 'R$ ' + totalProduto.toFixed(2);
            atualizarTotal();
        }
    });

    tbody.addEventListener('click', function (e) {
        if (e.target.closest('.remover-produto')) {
            const tr = e.target.closest('tr');
            const produtoId = parseInt(tr.dataset.produtoId);
            produtosSelecionados.delete(produtoId);
            tr.remove();
            atualizarTotal();
        }
    });

    function atualizarTotal() {
        let total = 0;
        tbody.querySelectorAll('tr').forEach(tr => {
            const qtd = parseInt(tr.querySelector('.quantidade').value) || 0;
            const preco = parseFloat(produtosSelecionados.get(parseInt(tr.dataset.produtoId)).preco);
            total += qtd * preco;
        });
        totalSpan.textContent = total.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
    }
});
</script>
@endpush
