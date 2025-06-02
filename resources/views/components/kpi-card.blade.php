<div class="col">
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
            <div class="mb-2 text-{{ $cor ?? 'primary' }}">
                <i class="bi {{ $icone ?? 'bi-circle' }} fs-3"></i>
            </div>
            <div class="fw-bold text-muted">{{ $titulo }}</div>
            <div class="fs-4">{{ $valor }}</div>
        </div>
    </div>
</div>
