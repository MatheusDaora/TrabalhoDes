<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Funcionario;
use App\Models\Produto;
use App\Models\Equipamento;
use App\Models\OrdemServico;
use App\Models\Pedido;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AssistenciaTest extends TestCase
{
    protected function getAdmin()
    {
        return User::where('email', 'admin@techassist.com')->first() ?? User::factory()->create();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_login_screen_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('TechAssist');
    }

    public function test_dashboard_renders_for_authenticated_user(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/');
        $response->assertStatus(200);
        $response->assertSee('Painel de Controle');
    }

    public function test_clientes_crud_and_search(): void
    {
        $admin = $this->getAdmin();

        // Index
        $response = $this->actingAs($admin)->get('/cliente');
        $response->assertStatus(200);

        // Busca
        $response = $this->actingAs($admin)->get('/cliente?busca=Joao');
        $response->assertStatus(200);

        // Create form
        $response = $this->actingAs($admin)->get('/cliente/create');
        $response->assertStatus(200);

        // Store
        $cpf = '999.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(10, 99);
        $response = $this->actingAs($admin)->post('/cliente', [
            'nome_razao_social' => 'Cliente Teste Automatizado',
            'cpf_cnpj' => $cpf,
            'email' => 'teste@cliente.com',
            'telefone' => '(49) 99999-8888',
            'data_cadastro' => '2026-01-01',
            'status' => 'Ativo',
            'rua' => 'Rua de Teste',
            'numero' => '100',
            'bairro' => 'Centro',
            'cep' => '89800-000',
            'cidade' => 'Chapecó',
            'estado' => 'SC',
        ]);
        $response->assertRedirect('/cliente');

        $cliente = Cliente::where('cpf_cnpj', $cpf)->first();
        $this->assertNotNull($cliente);

        // Show
        $response = $this->actingAs($admin)->get('/cliente/' . $cliente->id_cliente);
        $response->assertStatus(200);

        // Update
        $response = $this->actingAs($admin)->put('/cliente/' . $cliente->id_cliente, [
            'nome_razao_social' => 'Cliente Teste Atualizado',
            'cpf_cnpj' => $cpf,
            'email' => 'teste.atualizado@cliente.com',
            'telefone' => '(49) 99999-7777',
            'data_cadastro' => '2026-01-01',
            'status' => 'Ativo',
        ]);
        $response->assertRedirect('/cliente');

        // Destroy
        $response = $this->actingAs($admin)->delete('/cliente/' . $cliente->id_cliente);
        $response->assertRedirect('/cliente');
    }

    public function test_produto_crud_with_image_upload_and_deletion(): void
    {
        Storage::fake('public');
        $admin = $this->getAdmin();

        $imagem = UploadedFile::fake()->image('produto_teste.jpg', 300, 300);

        // Store com upload
        $response = $this->actingAs($admin)->post('/produto', [
            'nome' => 'Placa Mãe B550M Teste',
            'categoria' => 'Hardware',
            'marca' => 'Asus',
            'preco_unitario' => 699.90,
            'quantidade_estoque' => 10,
            'tipo_produto' => 'Peça Nova',
            'imagem' => $imagem,
        ]);
        $response->assertRedirect('/produto');

        $produto = Produto::where('nome', 'Placa Mãe B550M Teste')->first();
        $this->assertNotNull($produto);
        $this->assertNotNull($produto->imagem);
        Storage::disk('public')->assertExists($produto->imagem);

        // Index
        $response = $this->actingAs($admin)->get('/produto');
        $response->assertStatus(200);

        // Destroy - deve excluir o arquivo de imagem
        $pathImagem = $produto->imagem;
        $response = $this->actingAs($admin)->delete('/produto/' . $produto->id_produto);
        $response->assertRedirect('/produto');

        Storage::disk('public')->assertMissing($pathImagem);
    }

    public function test_equipamento_crud_with_image_upload(): void
    {
        Storage::fake('public');
        $admin = $this->getAdmin();
        $cliente = Cliente::first();

        $imagem = UploadedFile::fake()->image('notebook_teste.jpg', 400, 400);

        $serial = 'TESTE-SERIE-' . rand(1000, 9999);
        $response = $this->actingAs($admin)->post('/equipamento', [
            'id_cliente' => $cliente->id_cliente,
            'numero_serie' => $serial,
            'modelo' => 'Notebook Acer Nitro 5',
            'marca' => 'Acer',
            'imagem' => $imagem,
        ]);
        $response->assertRedirect('/equipamento');

        $equipamento = Equipamento::where('numero_serie', $serial)->first();
        $this->assertNotNull($equipamento);
        Storage::disk('public')->assertExists($equipamento->imagem);

        // Destroy
        $path = $equipamento->imagem;
        $response = $this->actingAs($admin)->delete('/equipamento/' . $equipamento->id_equipamento);
        $response->assertRedirect('/equipamento');
        Storage::disk('public')->assertMissing($path);
    }

    public function test_ordem_servico_crud(): void
    {
        $admin = $this->getAdmin();
        $cliente = Cliente::first();
        $funcionario = Funcionario::first();
        $equipamento = Equipamento::first();

        $response = $this->actingAs($admin)->post('/ordem_servico', [
            'id_cliente' => $cliente->id_cliente,
            'id_funcionario' => $funcionario->id_funcionario,
            'id_equipamento' => $equipamento->id_equipamento,
            'data_abertura' => '2026-02-01',
            'diagnostico' => 'Diagnóstico de teste automatizado.',
            'orcamento' => 250.00,
            'status' => 'Em Análise',
        ]);

        $os = OrdemServico::where('diagnostico', 'Diagnóstico de teste automatizado.')->first();
        $this->assertNotNull($os);

        $response = $this->actingAs($admin)->get('/ordem_servico/' . $os->id_os);
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->delete('/ordem_servico/' . $os->id_os);
        $response->assertRedirect('/ordem_servico');
    }

    public function test_relatorios_and_graficos_render(): void
    {
        $admin = $this->getAdmin();

        $response = $this->actingAs($admin)->get('/relatorios');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/relatorios/ordens-servico');
        $response->assertStatus(200);
        $response->assertSee('Relatório Geral de Ordens de Serviço');

        $response = $this->actingAs($admin)->get('/relatorios/produtos');
        $response->assertStatus(200);
        $response->assertSee('Relatório de Produtos e Estoque');

        $response = $this->actingAs($admin)->get('/graficos');
        $response->assertStatus(200);
        $response->assertSee('Gráficos Analíticos');
    }
}
