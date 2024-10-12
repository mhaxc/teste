@extends('layouts.app')

@section('content')
<h1>Clientes</h1>
<a href="{{ route('clientes.create') }}">Novo Cliente</a>
<table>
    <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Ações</th>
    </tr>
    @foreach ($clientes as $cliente)
    <tr>cliente
        <td>{{ $cliente->nome }}</td>
        <td>{{ $cliente->email }}</td>
        <td>{{ $cliente->telefone }}</td>
        <td>
            <a href="{{ route('clientes.edit', $cliente->id) }}">Editar</a>
            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Excluir</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
{{ $clientes->links() }}
@endsection
