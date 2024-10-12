@extends('layouts.app')

@section('content')
<h1>Pedidos</h1>
<a href="{{ route('pedidos.create') }}">Novo Pedido</a>
<form method="GET">
    <select name="status" onchange="this.form.submit()">
        <option value="">Todos</option>
        <option value="Em Aberto">Em Aberto</option>
        <option value="Pago">Pago</option>
        <option value="Cancelado">Cancelado</option>
    </select>
</form>
<table>
    <tr>
        <th>Cliente</th>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Total</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>
    @foreach ($pedidos as $pedido)
    <tr>
        <td>{{ $pedido->cliente->nome }}</td>
        <td>{{ $pedido->produto->nome }}</td>
        <td>{{ $pedido->quantidade }}</td>
        <td>{{ $pedido->total_preco }}</td>
        <td>{{ $pedido->status }}</td>
        <td>
            <a href="{{ route('pedidos.edit', $pedido->id) }}">Editar</a>
            <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Excluir</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
{{ $pedidos->links() }}
@endsection
