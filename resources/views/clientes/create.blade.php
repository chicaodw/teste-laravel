@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('clientes.index') }}">Clientes</a>
            </li>
            <li class="breadcrumb-item active">Novo Cliente</li>
        </ol>
    </nav>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf
        @include('clientes._form')
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
    </form>
</div>
@endsection
