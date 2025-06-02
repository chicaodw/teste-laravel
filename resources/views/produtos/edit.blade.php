@extends('layouts.app')

@section('content')
<div class="container">
     <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('produtos.index') }}">Produtos</a>
            </li>
            <li class="breadcrumb-item active">Editar Produto</li>
        </ol>
    </nav>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produtos.update', $produto) }}" method="POST">
        @csrf
        @method('PUT')
        @include('produtos._form', ['produto' => $produto])
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.jQuery) {
        $('#preco').inputmask('currency', {
            radixPoint: ",",
            groupSeparator: ".",
            allowMinus: false,
            prefix: 'R$ ',
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
    }

    const inputImagem = document.getElementById('imagem');
    const preview = document.getElementById('imagem-preview');
    const imagemFinal = document.getElementById('imagem-final');
    const campoHidden = document.getElementById('imagem_cortada');
    const modalEl = document.getElementById('modalCrop');
    const cropBtn = document.getElementById('cropBtn');
    const modal = new bootstrap.Modal(modalEl);

    let cropper = null;

    inputImagem?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.onload = function () {
                modal.show();
            };
        };
        reader.readAsDataURL(file);
    });

    modalEl?.addEventListener('shown.bs.modal', function () {
        cropper = new Cropper(preview, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1
        });
    });

    modalEl?.addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });

    cropBtn?.addEventListener('click', function () {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 500,
            height: 500
        });

        const base64 = canvas.toDataURL('image/jpeg', 0.9);
        imagemFinal.src = base64;
        imagemFinal.style.display = 'block';
        campoHidden.value = base64;
        document.getElementById('preview-final').style.display = 'block';
        modal.hide();
    });

    @if (!empty($produto->imagem))
        const imagemAtual = "{{ asset($produto->imagem) }}";
        const imgTag = document.getElementById('imagem-final');
        imgTag.src = imagemAtual;
        imgTag.style.display = 'block';
        document.getElementById('preview-final').style.display = 'block';
    @endif
});
</script>
@endpush
