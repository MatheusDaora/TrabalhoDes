<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\ItemPedido;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');
        $statusFiltro = $request->input('status');

        $query = Pedido::query()->with(['cliente', 'enderecoEntrega', 'itens.produto']);

        if (!empty($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('status', 'like', "%{$busca}%")
                  ->orWhereHas('cliente', function ($cq) use ($busca) {
                      $cq->where('nome_razao_social', 'like', "%{$busca}%")
                         ->orWhere('cpf_cnpj', 'like', "%{$busca}%");
                  });
            });
        }

        if (!empty($statusFiltro)) {
            $query->where('status', $statusFiltro);
        }

        $pedidos = $query->orderBy('data_pedido', 'desc')->paginate(10)->withQueryString();

        return view('pedido.index', compact('pedidos', 'busca', 'statusFiltro'));
    }

    public function create()
    {
        $clientes = Cliente::with('enderecos')->orderBy('nome_razao_social')->get();
        $enderecos = Endereco::with('cliente')->get();
        $produtos = Produto::where('quantidade_estoque', '>', 0)->orderBy('nome')->get();

        return view('pedido.create', compact('clientes', 'enderecos', 'produtos'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'data_pedido' => 'required|date',
            'status' => 'required|string|max:50',
            'requer_entrega' => 'nullable|boolean',
            'id_endereco_entrega' => 'nullable|exists:enderecos,id_endereco',
            'produtos' => 'required|array|min:1',
            'produtos.*.id_produto' => 'required|exists:produtos,id_produto',
            'produtos.*.quantidade' => 'required|integer|min:1',
        ], [
            'id_cliente.required' => 'Selecione o cliente que realizou o pedido.',
            'data_pedido.required' => 'A data do pedido é obrigatória.',
            'status.required' => 'O status do pedido é obrigatório.',
            'produtos.required' => 'Adicione pelo menos um produto ao pedido.',
            'produtos.min' => 'Adicione pelo menos um produto ao pedido.',
        ]);

        $requerEntrega = $request->boolean('requer_entrega');
        $idEnderecoEntrega = $requerEntrega ? $request->input('id_endereco_entrega') : null;

        DB::transaction(function () use ($dados, $requerEntrega, $idEnderecoEntrega) {
            $valorTotal = 0;
            $itensParaSalvar = [];

            foreach ($dados['produtos'] as $item) {
                $produto = Produto::findOrFail($item['id_produto']);
                $subtotal = $produto->preco_unitario * $item['quantidade'];
                $valorTotal += $subtotal;

                $itensParaSalvar[] = [
                    'id_produto' => $produto->id_produto,
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $produto->preco_unitario,
                ];

                // Atualiza o estoque
                $produto->decrement('quantidade_estoque', $item['quantidade']);
            }

            $pedido = Pedido::create([
                'id_cliente' => $dados['id_cliente'],
                'data_pedido' => $dados['data_pedido'],
                'status' => $dados['status'],
                'valor_total' => $valorTotal,
                'requer_entrega' => $requerEntrega,
                'id_endereco_entrega' => $idEnderecoEntrega,
            ]);

            foreach ($itensParaSalvar as $item) {
                $item['id_pedido'] = $pedido->id_pedido;
                ItemPedido::create($item);
            }
        });

        return redirect()->route('pedido.index')->with('sucesso', 'Pedido registrado com sucesso!');
    }

    public function show($id)
    {
        $pedido = Pedido::with(['cliente.enderecos', 'enderecoEntrega', 'itens.produto'])
            ->findOrFail($id);

        return view('pedido.show', compact('pedido'));
    }

    public function edit($id)
    {
        $pedido = Pedido::with(['itens.produto', 'cliente.enderecos'])->findOrFail($id);
        $enderecos = Endereco::where('id_cliente', $pedido->id_cliente)->get();

        return view('pedido.edit', compact('pedido', 'enderecos'));
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $dados = $request->validate([
            'status' => 'required|string|max:50',
            'requer_entrega' => 'nullable|boolean',
            'id_endereco_entrega' => 'nullable|exists:enderecos,id_endereco',
        ], [
            'status.required' => 'O status é obrigatório.',
        ]);

        $requerEntrega = $request->boolean('requer_entrega');
        $idEnderecoEntrega = $requerEntrega ? $request->input('id_endereco_entrega') : null;

        $pedido->update([
            'status' => $dados['status'],
            'requer_entrega' => $requerEntrega,
            'id_endereco_entrega' => $idEnderecoEntrega,
        ]);

        return redirect()->route('pedido.index')->with('sucesso', "Pedido #{$pedido->id_pedido} atualizado com sucesso!");
    }

    public function destroy($id)
    {
        $pedido = Pedido::with('itens')->findOrFail($id);
        $numero = $pedido->id_pedido;

        // Ao cancelar/deletar, devolve os itens ao estoque
        foreach ($pedido->itens as $item) {
            Produto::where('id_produto', $item->id_produto)->increment('quantidade_estoque', $item->quantidade);
        }

        $pedido->delete();

        return redirect()->route('pedido.index')->with('sucesso', "Pedido #{$numero} excluído e estoque restaurado!");
    }
}
