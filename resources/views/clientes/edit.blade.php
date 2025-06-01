@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('clientes.index') }}">Clientes</a>
            </li>
            <li class="breadcrumb-item active">Editar Cliente</li>
        </ol>
    </nav>
    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @csrf
        @method('PUT')
        @include('clientes._form')
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </div>
    </form>
</div>
@endsection
