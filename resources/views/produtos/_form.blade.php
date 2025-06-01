<!-- Nome -->
<div class="mb-4">
    <label for="nome" class="form-label">Nome do Produto</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-box"></i></span>
        <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', $produto->nome ?? '') }}" required autofocus>
    </div>
</div>

<!-- Preço -->
<div class="mb-4">
    <label for="preco" class="form-label">Preço</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
        <input type="text" class="form-control text-start" name="preco" id="preco" value="{{ old('preco', $produto->preco ?? '') }}" required>
    </div>
</div>

<!-- Estoque -->
<div class="mb-4">
    <label for="estoque" class="form-label">Estoque</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-stack"></i></span>
        <input type="number" class="form-control" name="estoque" id="estoque" value="{{ old('estoque', $produto->estoque ?? '') }}" required>
    </div>
</div>

<!-- Descrição -->
<div class="mb-4">
    <label for="descricao" class="form-label">Descrição</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
        <textarea class="form-control" name="descricao" id="descricao" rows="3" required>{{ old('descricao', $produto->descricao ?? '') }}</textarea>
    </div>
</div>

<!-- Imagem -->
<div class="mb-4">
    <label for="imagem" class="form-label">Imagem do Produto</label>

    <div class="mt-2" id="preview-final" style="display:none;">
        <p class="mb-1 fw-bold">Preview da Imagem:</p>
        <img id="imagem-final" src="#" class="img-thumbnail" width="150">
    </div>

    <input type="file" class="form-control mt-2" id="imagem" accept="image/*">
    <input type="hidden" name="imagem_cortada" id="imagem_cortada">

    <!-- Modal de Corte -->
    <div class="modal fade" id="modalCrop" tabindex="-1" aria-labelledby="modalCropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cortar Imagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body text-center">
                    <div style="max-height: 60vh; overflow: auto;">
                        <img id="imagem-preview" src="#" alt="Preview da Imagem" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cropBtn" class="btn btn-success">
                        <i class="bi bi-scissors"></i> Cortar e Usar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
