# TechAssist - Sistema de Assistência Técnica de Computadores

**Disciplina:** Desenvolvimento de Sistemas II  
**Curso:** Técnico em Informática Integrado - IFSC  
**Trabalho Avaliativo 01:** Projeto com Laravel  

---

## 💻 Sobre o Projeto

O **TechAssist** é um sistema web desenvolvido em **Laravel** para gerenciamento de atendimentos de assistência técnica de computadores e vendas de componentes, seguindo fielmente o modelo do diagrama entidade-relacionamento (DER).

O sistema conta com autenticação por sessão, CRUDs completos com validação de dados, upload e exclusão de imagens, relacionamentos 1:1 e 1:N com selects e exibição de nomes em vez de identificadores (IDs), buscas em todas as listagens, emissão de relatórios formatados para PDF e gráficos analíticos dinâmicos com dados reais do banco de dados.

---

## 🛠️ Entidades Implementadas (Fidedignas ao Diagrama)

1. **Cliente (`clientes`)**:
   - `id_cliente`, `nome_razao_social`, `cpf_cnpj`, `email`, `telefone`, `data_nascimento`, `data_cadastro`, `status`.
2. **Endereço (`enderecos`)**:
   - `id_endereco`, `id_cliente` (FK), `tipo_endereco`, `rua`, `numero`, `bairro`, `cep`, `cidade`, `estado`, `principal`.
3. **Funcionário (`funcionarios`)**:
   - `id_funcionario`, `nome`, `email`, `perfil`, `data_admissao`.
4. **Produto (`produtos`)**:
   - `id_produto`, `nome`, `categoria`, `preco_unitario`, `quantidade_estoque`, `marca`, `tipo_produto`, `imagem`.
5. **Equipamento (`equipamentos`)**:
   - `id_equipamento`, `id_cliente` (FK), `numero_serie`, `modelo`, `marca`, `imagem`.
6. **Ordem de Serviço (`ordens_servico`)**:
   - `id_os`, `id_cliente` (FK), `id_funcionario` (FK), `id_equipamento` (FK - Relacionamento 1:1), `data_abertura`, `diagnostico`, `orcamento`, `status`, `data_conclusao`.
7. **Pedido (`pedidos`)**:
   - `id_pedido`, `id_cliente` (FK), `id_endereco_entrega` (FK), `data_pedido`, `status`, `valor_total`, `requer_entrega`.
8. **Item do Pedido (`itens_pedido`)**:
   - `id_item_pedido`, `id_pedido` (FK), `id_produto` (FK), `quantidade`, `preco_unitario`.

---

## 📋 Como Executar o Projeto

### 1. Clonar ou descompactar o projeto
Abra o terminal na pasta do projeto.

### 2. Configurar o ambiente (`.env`)
Copie o arquivo de exemplo caso ainda não tenha o `.env`:
```bash
cp .env.example .env
```

Gere a chave da aplicação:
```bash
php artisan key:generate
```

Configure o banco de dados no `.env` (padrão MySQL/Laragon):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_assistencia
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Criar as tabelas e popular o banco com os Seeders
Execute o comando do Laravel para rodar as migrations e os seeders com os dados iniciais:
```bash
php artisan migrate:fresh --seed
```

*Nota: Um arquivo `banco.sql` também está disponível na raiz do projeto para importação direta no phpMyAdmin ou MySQL Workbench.*

### 4. Criar o link simbólico de uploads
```bash
php artisan storage:link
```

### 5. Iniciar o servidor de desenvolvimento
```bash
php artisan serve
```

Acesse o sistema no navegador:
```
http://localhost:8000
```

---

## 🔑 Credenciais para Avaliação do Professor

- **E-mail:** `admin@techassist.com`
- **Senha:** `admin123`

*(O sistema também permite criar novos usuários através da tela de cadastro `/register`)*

---

## 📊 Checklist dos Critérios Avaliativos Atendidos

- [x] **Organização do Código:** Arquitetura limpa seguindo o padrão MVC do Laravel, sem bibliotecas externas desnecessárias.
- [x] **Layout Profissional:** Responsivo e bem estruturado utilizando Tailwind CSS (via CDN) com barra lateral e modo mobile.
- [x] **CRUDs Completos (mínimo 5):** Clientes, Funcionários, Produtos, Equipamentos, Ordens de Serviço e Pedidos.
- [x] **Upload de Imagens (mínimo 2):** Implementado em Produtos e Equipamentos, com miniaturas nas listagens, exibição na edição e exclusão automática do arquivo ao deletar o registro.
- [x] **Busca em Todas as Listagens:** Campo de busca funcional em cada uma das listagens do sistema.
- [x] **Validação de Dados:** Todos os campos obrigatórios validados com mensagens de erro amigáveis ao usuário.
- [x] **Relacionamentos:**
  - **1:1 (um para um):** Ordem de Serviço <-> Equipamento.
  - **1:N (um para muitos):** Cliente &rarr; Endereços, Cliente &rarr; Equipamentos, Cliente &rarr; O.S., Cliente &rarr; Pedidos, Funcionário &rarr; O.S., Pedido &rarr; Itens, Produto &rarr; Itens.
  - Exibição de nomes em vez de IDs e selects dinâmicos em todos os formulários.
- [x] **Relatórios em PDF:** Dois relatórios completos formatados para folha A4 e prontos para impressão/salvar em PDF (Ordens de Serviço e Estoque de Produtos).
- [x] **Dois Gráficos Analíticos em formatos diferentes:** 
  - Gráfico 1 (Rosca / Doughnut): Distribuição de Ordens de Serviço por Status.
  - Gráfico 2 (Barras / Bar): Quantidade de Peças em Estoque por Categoria.
- [x] **Script do Banco de Dados:** Arquivo `banco.sql` gerado e atualizado na raiz do projeto.
