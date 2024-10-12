<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pedidos = Pedido::with(['cliente', 'produto'])
        ->when($request->status, function ($query, $status) {
            return $query->where('status', $status);
        })
            ->paginate(20);

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $produtos = Produto::all();
        return view('pedidos.create', compact('clientes', 'produtos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:Em Aberto,Pago,Cancelado',
        ]);

        $produto = Produto::find($request->produto_id);
        $totalPreco = $produto->preco * $request->quantidade;

        Pedido::create([
            'cliente_id' => $request->cliente_id,
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            'total_preco' => $totalPreco,
            'status' => $request->status,
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido criado com sucesso!');
    }

    public function edit(Pedido $Pedido)
    {
        $clientes = Cliente::all();
        $produtos = Produto::all();
        return view('pedidos.edit', compact('pedido', 'clientes', 'produtos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
     {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'status' => 'required|in:Em Aberto,Pago,Cancelado',
        ]);

        $produto = Produto::find($request->product_id);
        $totalPreco = $produto->preco * $request->quantity;

        $pedido->update([
            'cliente_id' => $request->cliente_id,
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            'total_preco' => $totalPreco,
            'status' => $request->status,
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido excluído com sucesso!');

    }
}
