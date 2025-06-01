<div class="mb-3">
    <label for="nome" class="form-label fw-semibold">
        <i class="bi bi-person-fill me-1 text-primary"></i> Nome <span class="text-danger">*</span>
    </label>
    <input type="text"
           class="form-control @error('nome') is-invalid @enderror"
           id="nome"
           name="nome"
           value="{{ old('nome', $cliente->nome ?? '') }}"
           required
           placeholder="Digite o nome completo">
    @error('nome')
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
           value="{{ old('email', $cliente->email ?? '') }}"
           required
           pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
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
           inputmode="numeric"
           maxlength="15"
           value="{{ old('telefone', $cliente->telefone ?? '') }}"
           required
           placeholder="(99) 99999-9999"
           title="Formato esperado: (99) 99999-9999">
    @error('telefone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>