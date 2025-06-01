@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Logs de Atividade</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('logs.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por usuário, ação ou modelo..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Usuário</th>
                    <th>Ação</th>
                    <th>Modelo</th>
                    <th>ID do Modelo</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->user->name ?? 'N/A' }}</td>
                        <td>{{ ucfirst($log->action) }}</td>
                        <td>{{ $log->model }}</td>
                        <td>{{ $log->model_id }}</td>
                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhum log encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $logs->appends(request()->query())->links() }}
    </div>
</div>
@endsection
