<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\Funcionario;
use App\Models\Produto;
use App\Models\Equipamento;
use App\Models\OrdemServico;
use App\Models\Pedido;
use App\Models\ItemPedido;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuário Administrador para Sessão e Apresentação
        User::firstOrCreate(
            ['email' => 'admin@TechForge.com'],
            [
                'name' => 'Professor Avaliador',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Clientes
        $clientesDados = [
            [
                'nome_razao_social' => 'João Pedro Guimarães',
                'cpf_cnpj' => '123.456.789-01',
                'email' => 'joao.guimaraes@email.com',
                'telefone' => '(49) 98811-2233',
                'data_nascimento' => '1990-05-14',
                'data_cadastro' => '2025-02-10',
                'status' => 'Ativo',
            ],
            [
                'nome_razao_social' => 'Camila Fernandes Rocha',
                'cpf_cnpj' => '234.567.890-12',
                'email' => 'camila.rocha@email.com',
                'telefone' => '(49) 99122-3344',
                'data_nascimento' => '1995-11-22',
                'data_cadastro' => '2025-03-01',
                'status' => 'Ativo',
            ],
            [
                'nome_razao_social' => 'Inova Soluções Tecnológicas Ltda',
                'cpf_cnpj' => '12.345.678/0001-90',
                'email' => 'contato@inovasolucoes.com.br',
                'telefone' => '(49) 3322-4455',
                'data_nascimento' => null,
                'data_cadastro' => '2025-01-15',
                'status' => 'Ativo',
            ],
            [
                'nome_razao_social' => 'Lucas Vinícius Mendes',
                'cpf_cnpj' => '345.678.901-23',
                'email' => 'lucas.mendes@email.com',
                'telefone' => '(49) 98455-6677',
                'data_nascimento' => '2001-08-30',
                'data_cadastro' => '2025-04-12',
                'status' => 'Ativo',
            ],
            [
                'nome_razao_social' => 'Beatriz Helena Silveira',
                'cpf_cnpj' => '456.789.012-34',
                'email' => 'beatriz.silveira@email.com',
                'telefone' => '(49) 99988-7766',
                'data_nascimento' => '1988-03-09',
                'data_cadastro' => '2025-05-20',
                'status' => 'Ativo',
            ],
            [
                'nome_razao_social' => 'Mercado Central de Chapecó ME',
                'cpf_cnpj' => '23.456.789/0001-01',
                'email' => 'financeiro@mercadocentral.com',
                'telefone' => '(49) 3323-9988',
                'data_nascimento' => null,
                'data_cadastro' => '2025-06-05',
                'status' => 'Ativo',
            ],
        ];

        $clientes = [];
        foreach ($clientesDados as $dado) {
            $clientes[] = Cliente::create($dado);
        }

        // 3. Endereços
        $enderecosDados = [
            [
                'id_cliente' => $clientes[0]->id_cliente,
                'tipo_endereco' => 'Residencial',
                'rua' => 'Avenida Getúlio Vargas',
                'numero' => '1420',
                'bairro' => 'Centro',
                'cep' => '89801-000',
                'cidade' => 'Chapecó',
                'estado' => 'SC',
                'principal' => true,
            ],
            [
                'id_cliente' => $clientes[1]->id_cliente,
                'tipo_endereco' => 'Residencial',
                'rua' => 'Rua Fernando Machado',
                'numero' => '550',
                'bairro' => 'São Cristóvão',
                'cep' => '89803-010',
                'cidade' => 'Chapecó',
                'estado' => 'SC',
                'principal' => true,
            ],
            [
                'id_cliente' => $clientes[2]->id_cliente,
                'tipo_endereco' => 'Comercial',
                'rua' => 'Rua Nereu Ramos',
                'numero' => '850',
                'bairro' => 'Centro',
                'cep' => '89801-023',
                'cidade' => 'Chapecó',
                'estado' => 'SC',
                'principal' => true,
            ],
            [
                'id_cliente' => $clientes[2]->id_cliente,
                'tipo_endereco' => 'Entrega',
                'rua' => 'Rua Marechal Deodoro',
                'numero' => '210',
                'bairro' => 'Santa Maria',
                'cep' => '89812-100',
                'cidade' => 'Chapecó',
                'estado' => 'SC',
                'principal' => false,
            ],
            [
                'id_cliente' => $clientes[3]->id_cliente,
                'tipo_endereco' => 'Residencial',
                'rua' => 'Rua Sete de Setembro',
                'numero' => '315',
                'bairro' => 'Presidente Médici',
                'cep' => '89801-140',
                'cidade' => 'Chapecó',
                'estado' => 'SC',
                'principal' => true,
            ],
            [
                'id_cliente' => $clientes[4]->id_cliente,
                'tipo_endereco' => 'Residencial',
                'rua' => 'Rua Uruguai',
                'numero' => '780',
                'bairro' => 'Maria Goretti',
                'cep' => '89801-400',
                'cidade' => 'Chapecó',
                'estado' => 'SC',
                'principal' => true,
            ],
            [
                'id_cliente' => $clientes[5]->id_cliente,
                'tipo_endereco' => 'Comercial',
                'rua' => 'Avenida General Osório',
                'numero' => '1100',
                'bairro' => 'Jardim Itália',
                'cep' => '89802-210',
                'cidade' => 'Chapecó',
                'estado' => 'SC',
                'principal' => true,
            ],
        ];

        $enderecos = [];
        foreach ($enderecosDados as $dado) {
            $enderecos[] = Endereco::create($dado);
        }

        // 4. Funcionários
        $funcionariosDados = [
            [
                'nome' => 'Carlos Eduardo Silva',
                'email' => 'carlos.silva@TechForge.com',
                'perfil' => 'Técnico de Manutenção',
                'data_admissao' => '2023-03-15',
            ],
            [
                'nome' => 'Mariana Ribeiro Santos',
                'email' => 'mariana.santos@TechForge.com',
                'perfil' => 'Técnica de Hardware',
                'data_admissao' => '2023-08-01',
            ],
            [
                'nome' => 'Lucas Pereira Lima',
                'email' => 'lucas.lima@TechForge.com',
                'perfil' => 'Atendente Técnico',
                'data_admissao' => '2024-02-10',
            ],
            [
                'nome' => 'Ana Paula Souza',
                'email' => 'ana.souza@TechForge.com',
                'perfil' => 'Gerente de Laboratório',
                'data_admissao' => '2022-01-20',
            ],
        ];

        $funcionarios = [];
        foreach ($funcionariosDados as $dado) {
            $funcionarios[] = Funcionario::create($dado);
        }

        // 5. Produtos
        $produtosDados = [
            [
                'nome' => 'SSD Kingston NV2 1TB M.2 2280 NVMe',
                'categoria' => 'Armazenamento',
                'preco_unitario' => 389.90,
                'quantidade_estoque' => 15,
                'marca' => 'Kingston',
                'tipo_produto' => 'Peça Nova',
                'imagem' => null,
            ],
            [
                'nome' => 'Memória RAM Kingston Fury Beast 16GB DDR4 3200MHz',
                'categoria' => 'Memória RAM',
                'preco_unitario' => 249.00,
                'quantidade_estoque' => 22,
                'marca' => 'Kingston',
                'tipo_produto' => 'Peça Nova',
                'imagem' => null,
            ],
            [
                'nome' => 'Fonte Corsair CV650 650W 80 Plus Bronze',
                'categoria' => 'Fonte de Alimentação',
                'preco_unitario' => 419.90,
                'quantidade_estoque' => 8,
                'marca' => 'Corsair',
                'tipo_produto' => 'Peça Nova',
                'imagem' => null,
            ],
            [
                'nome' => 'Pasta Térmica Noctua NT-H1 3.5g Alta Condutividade',
                'categoria' => 'Consumível',
                'preco_unitario' => 69.90,
                'quantidade_estoque' => 30,
                'marca' => 'Noctua',
                'tipo_produto' => 'Consumível',
                'imagem' => null,
            ],
            [
                'nome' => 'Placa de Vídeo Galax GeForce RTX 4060 8GB GDDR6',
                'categoria' => 'Placa de Vídeo',
                'preco_unitario' => 2199.00,
                'quantidade_estoque' => 5,
                'marca' => 'Galax',
                'tipo_produto' => 'Peça Nova',
                'imagem' => null,
            ],
            [
                'nome' => 'Teclado Mecânico Redragon Kumara Switch Blue',
                'categoria' => 'Periféricos',
                'preco_unitario' => 189.90,
                'quantidade_estoque' => 12,
                'marca' => 'Redragon',
                'tipo_produto' => 'Acessório',
                'imagem' => null,
            ],
            [
                'nome' => 'Mouse Gamer Logitech G203 Lightsync RGB 8000 DPI',
                'categoria' => 'Periféricos',
                'preco_unitario' => 139.90,
                'quantidade_estoque' => 18,
                'marca' => 'Logitech',
                'tipo_produto' => 'Acessório',
                'imagem' => null,
            ],
            [
                'nome' => 'Cooler para Processador DeepCool Gammaxx AG400',
                'categoria' => 'Refrigeração',
                'preco_unitario' => 149.90,
                'quantidade_estoque' => 10,
                'marca' => 'DeepCool',
                'tipo_produto' => 'Peça Nova',
                'imagem' => null,
            ],
            [
                'nome' => 'SSD Kingston A400 480GB SATA III 2.5',
                'categoria' => 'Armazenamento',
                'preco_unitario' => 199.90,
                'quantidade_estoque' => 20,
                'marca' => 'Kingston',
                'tipo_produto' => 'Peça Nova',
                'imagem' => null,
            ],
        ];

        $produtos = [];
        foreach ($produtosDados as $dado) {
            $produtos[] = Produto::create($dado);
        }

        // 6. Equipamentos (Computadores / Notebooks de clientes)
        $equipamentosDados = [
            [
                'id_cliente' => $clientes[0]->id_cliente,
                'numero_serie' => 'DELL-INSP-98214',
                'modelo' => 'Notebook Dell Inspiron 15 3520 i5 11ª Geração',
                'marca' => 'Dell',
                'imagem' => null,
            ],
            [
                'id_cliente' => $clientes[1]->id_cliente,
                'numero_serie' => 'LEN-THINK-77123',
                'modelo' => 'Notebook Lenovo ThinkPad E14 Ryzen 5',
                'marca' => 'Lenovo',
                'imagem' => null,
            ],
            [
                'id_cliente' => $clientes[2]->id_cliente,
                'numero_serie' => 'SRV-HP-PROLIANT-01',
                'modelo' => 'Servidor Torre HP ProLiant ML30 Gen10',
                'marca' => 'HP',
                'imagem' => null,
            ],
            [
                'id_cliente' => $clientes[3]->id_cliente,
                'numero_serie' => 'PCG-CUSTOM-4411',
                'modelo' => 'Desktop Gamer Customizado Ryzen 7 5700X / B550',
                'marca' => 'Custom',
                'imagem' => null,
            ],
            [
                'id_cliente' => $clientes[4]->id_cliente,
                'numero_serie' => 'APL-MAC-AIR-M1-22',
                'modelo' => 'MacBook Air 13 M1 8GB 256GB Silver',
                'marca' => 'Apple',
                'imagem' => null,
            ],
            [
                'id_cliente' => $clientes[5]->id_cliente,
                'numero_serie' => 'POS-MASTER-5589',
                'modelo' => 'Computador PDV Positivo Master D580 Core i3',
                'marca' => 'Positivo',
                'imagem' => null,
            ],
        ];

        $equipamentos = [];
        foreach ($equipamentosDados as $dado) {
            $equipamentos[] = Equipamento::create($dado);
        }

        // 7. Ordens de Serviço (Relacionamento 1:1 com Equipamento, 1:N com Cliente e Funcionario)
        $ordensServicoDados = [
            [
                'id_cliente' => $clientes[0]->id_cliente,
                'id_funcionario' => $funcionarios[0]->id_funcionario,
                'id_equipamento' => $equipamentos[0]->id_equipamento,
                'data_abertura' => '2025-10-10',
                'diagnostico' => 'Notebook superaquecendo e desligando sozinho após 20 minutos de uso. Necessária limpeza interna do cooler e troca de pasta térmica.',
                'orcamento' => 150.00,
                'status' => 'Concluído',
                'data_conclusao' => '2025-10-12',
            ],
            [
                'id_cliente' => $clientes[1]->id_cliente,
                'id_funcionario' => $funcionarios[1]->id_funcionario,
                'id_equipamento' => $equipamentos[1]->id_equipamento,
                'data_abertura' => '2025-10-18',
                'diagnostico' => 'Lentidão severa ao inicializar o Windows 11. Sugerido upgrade de memória para 16GB e clonagem do sistema para NVMe.',
                'orcamento' => 380.00,
                'status' => 'Em Reparo',
                'data_conclusao' => null,
            ],
            [
                'id_cliente' => $clientes[2]->id_cliente,
                'id_funcionario' => $funcionarios[0]->id_funcionario,
                'id_equipamento' => $equipamentos[2]->id_equipamento,
                'data_abertura' => '2025-10-22',
                'diagnostico' => 'Falha intermitente na fonte redundante e aviso de alerta no painel de discos RAID.',
                'orcamento' => 850.00,
                'status' => 'Aprovado',
                'data_conclusao' => null,
            ],
            [
                'id_cliente' => $clientes[3]->id_cliente,
                'id_funcionario' => $funcionarios[1]->id_funcionario,
                'id_equipamento' => $equipamentos[3]->id_equipamento,
                'data_abertura' => '2025-10-25',
                'diagnostico' => 'PC não dá vídeo. Foi detectada falha no slot PCIe da placa de vídeo e cabo de alimentação frouxo.',
                'orcamento' => 220.00,
                'status' => 'Em Análise',
                'data_conclusao' => null,
            ],
            [
                'id_cliente' => $clientes[4]->id_cliente,
                'id_funcionario' => $funcionarios[3]->id_funcionario,
                'id_equipamento' => $equipamentos[4]->id_equipamento,
                'data_abertura' => '2025-10-28',
                'diagnostico' => 'Bateria estufada com pressão no trackpad. Realizada troca do módulo da bateria e higienização interna.',
                'orcamento' => 620.00,
                'status' => 'Concluído',
                'data_conclusao' => '2025-10-30',
            ],
            [
                'id_cliente' => $clientes[5]->id_cliente,
                'id_funcionario' => $funcionarios[0]->id_funcionario,
                'id_equipamento' => $equipamentos[5]->id_equipamento,
                'data_abertura' => '2025-11-01',
                'diagnostico' => 'Computador do caixa não liga. Fonte queimada após queda de energia.',
                'orcamento' => 310.00,
                'status' => 'Aguardando Peça',
                'data_conclusao' => null,
            ],
        ];

        foreach ($ordensServicoDados as $dado) {
            OrdemServico::create($dado);
        }

        // 8. Pedidos e Itens do Pedido
        $pedidosDados = [
            [
                'id_cliente' => $clientes[0]->id_cliente,
                'data_pedido' => '2025-10-15',
                'status' => 'Entregue',
                'valor_total' => 389.90,
                'requer_entrega' => true,
                'id_endereco_entrega' => $enderecos[0]->id_endereco,
                'itens' => [
                    ['id_produto' => $produtos[0]->id_produto, 'quantidade' => 1, 'preco_unitario' => 389.90],
                ],
            ],
            [
                'id_cliente' => $clientes[1]->id_cliente,
                'data_pedido' => '2025-10-20',
                'status' => 'Pago',
                'valor_total' => 329.80,
                'requer_entrega' => false,
                'id_endereco_entrega' => null,
                'itens' => [
                    ['id_produto' => $produtos[5]->id_produto, 'quantidade' => 1, 'preco_unitario' => 189.90],
                    ['id_produto' => $produtos[6]->id_produto, 'quantidade' => 1, 'preco_unitario' => 139.90],
                ],
            ],
            [
                'id_cliente' => $clientes[2]->id_cliente,
                'data_pedido' => '2025-10-25',
                'status' => 'Em Separação',
                'valor_total' => 2618.90,
                'requer_entrega' => true,
                'id_endereco_entrega' => $enderecos[3]->id_endereco,
                'itens' => [
                    ['id_produto' => $produtos[4]->id_produto, 'quantidade' => 1, 'preco_unitario' => 2199.00],
                    ['id_produto' => $produtos[2]->id_produto, 'quantidade' => 1, 'preco_unitario' => 419.90],
                ],
            ],
            [
                'id_cliente' => $clientes[3]->id_cliente,
                'data_pedido' => '2025-10-29',
                'status' => 'Pendente',
                'valor_total' => 498.00,
                'requer_entrega' => false,
                'id_endereco_entrega' => null,
                'itens' => [
                    ['id_produto' => $produtos[1]->id_produto, 'quantidade' => 2, 'preco_unitario' => 249.00],
                ],
            ],
            [
                'id_cliente' => $clientes[4]->id_cliente,
                'data_pedido' => '2025-11-02',
                'status' => 'Pago',
                'valor_total' => 219.80,
                'requer_entrega' => true,
                'id_endereco_entrega' => $enderecos[5]->id_endereco,
                'itens' => [
                    ['id_produto' => $produtos[3]->id_produto, 'quantidade' => 1, 'preco_unitario' => 69.90],
                    ['id_produto' => $produtos[7]->id_produto, 'quantidade' => 1, 'preco_unitario' => 149.90],
                ],
            ],
        ];

        foreach ($pedidosDados as $pDado) {
            $itens = $pDado['itens'];
            unset($pDado['itens']);
            $pedido = Pedido::create($pDado);

            foreach ($itens as $item) {
                $item['id_pedido'] = $pedido->id_pedido;
                ItemPedido::create($item);
            }
        }
    }
}
