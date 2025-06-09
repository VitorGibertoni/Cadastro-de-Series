# Documentação do Projeto Cadastro de Séries

# Projeto Realizado por

- Aisha Ramiro
- Bruna Scaramuzza
- Lucas Freitas
- Vitor Gibertoni

## Introdução

Este documento contém instruções detalhadas sobre como configurar e utilizar o sistema de Cadastro de Séries, desenvolvido com PHP, MySQL e Node.js. O sistema implementa as quatro operações básicas de um CRUD (Create, Read, Update, Delete) para gerenciar um catálogo de séries.

## Estrutura do Projeto

```
cadastro-series/
├── css/
│   └── style.css
├── js/
│   └── script.js
├── php/
│   ├── conexao.php
│   ├── crud_series.php
│   ├── index.php
│   └── teste_crud.php
├── sql/
│   └── database.sql
└── server.js
```

## Requisitos

- XAAMP v.3.3.0 ou superior
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Node.js 14 ou superior
- npm (gerenciador de pacotes do Node.js)

===========================================================================
## Como exercutar o projeto utilizando somente o XAAMP:

Baixe a pasta zip do projeto [clicando aqui](https://github.com/VitorGibertoni/Cadastro-de-Series/archive/refs/heads/master.zip), ou clonando o repositorio pelo terminal 

```bash
git clone https://github.com/VitorGibertoni/Cadastro-de-Series
```

1. Abra o XAMMP Control Panel.
2. Coloque a pasta do projeto "Cadastro-de-series" dentro da pasta HTDOCS , geramente em ```C:\xampp\htdocs```
3. Inicie (start) o Apache no XAAMP Control Panel
4. Inicie (start) o MySQL e clique em Admin, deve-se abrir uma aba em ``` http://localhost/phpmyadmin/ ```
5. Importe o arquivo database 
- se nao encontrar o botao, geralmente fica nessa pagina: http://localhost/phpmyadmin/index.php?route=/server/import&lang=pt_BR
- clique no botao ```escolher arquivo```
- abra a pasta do projeto, procure pela pasta "sql", importe o arquivo "database", vá para baixo da tela e clique em ```Importar```
6. No navegador, cole a URL  ``` http://localhost/Cadastro-de-Series/php/ ```

===========================================================================


### Configurando a Conexão (se necessário)

As configurações de conexão com o banco de dados estão no arquivo `php/conexao.php`. Se necessário, altere as seguintes linhas para corresponder às suas configurações:

```php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'cadastro_series';
```

## Utilizando o Sistema

### Página Principal

A página principal do sistema exibe um formulário para cadastro de séries e uma lista das séries já cadastradas.

### Cadastrando uma Nova Série

1. Preencha todos os campos do formulário "Nova Série".
2. Clique no botão "Cadastrar".
3. Uma mensagem de sucesso será exibida se o cadastro for bem-sucedido.

### Listando Séries

As séries cadastradas são automaticamente listadas na tabela abaixo do formulário.

### Pesquisando Séries

1. Digite o título ou parte do título da série no campo de pesquisa.
2. Clique no botão "Pesquisar".
3. A tabela será atualizada para mostrar apenas as séries que correspondem à sua pesquisa.

### Editando uma Série

1. Na tabela de séries, clique no botão "Editar" ao lado da série que deseja modificar.
2. O formulário será preenchido com os dados atuais da série.
3. Faça as alterações desejadas.
4. Clique no botão "Atualizar".

### Excluindo uma Série

1. Na tabela de séries, clique no botão "Excluir" ao lado da série que deseja remover.
2. Confirme a exclusão quando solicitado.

## Entendendo o Uso do SQL na Aplicação

### Operações CRUD no Banco de Dados

O sistema utiliza consultas SQL preparadas (prepared statements) para realizar as operações CRUD no banco de dados. Isso é feito através das funções no arquivo `php/crud_series.php`.

#### Create (Criar)

```php
$sql = "INSERT INTO series (titulo, genero, criador, ano_lancamento, temporadas, sinopse, avaliacao, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
```

Esta consulta insere uma nova série no banco de dados. Os pontos de interrogação (?) são marcadores de posição que serão substituídos pelos valores reais usando `bind_param`.

#### Read (Ler)

```php
$sql = "SELECT * FROM series ORDER BY titulo";
```

Esta consulta recupera todas as séries do banco de dados, ordenadas pelo título.

```php
$sql = "SELECT * FROM series WHERE id = ?";
```

Esta consulta recupera uma série específica pelo seu ID.

#### Update (Atualizar)

```php
$sql = "UPDATE series SET titulo = ?, genero = ?, criador = ?, ano_lancamento = ?, 
        temporadas = ?, sinopse = ?, avaliacao = ?, status = ? WHERE id = ?";
```

Esta consulta atualiza os dados de uma série existente no banco de dados.

#### Delete (Excluir)

```php
$sql = "DELETE FROM series WHERE id = ?";
```

Esta consulta remove uma série do banco de dados pelo seu ID.

### Prepared Statements, bind_param e fetch_assoc

#### Prepared Statements

Prepared statements são consultas SQL pré-compiladas que podem ser executadas várias vezes com diferentes valores. Elas ajudam a prevenir ataques de injeção SQL, tornando o código mais seguro.

Exemplo:
```php
$stmt = $conexao->prepare($sql);
```

#### bind_param

O método `bind_param` é usado para vincular variáveis PHP aos marcadores de posição (?) nas consultas preparadas. O primeiro argumento especifica os tipos de dados dos valores (s para string, i para inteiro, d para double, etc.).

Exemplo:
```php
$stmt->bind_param("sssiisd", $titulo, $genero, $criador, $ano_lancamento, $temporadas, $sinopse, $avaliacao, $status);
```

#### fetch_assoc

O método `fetch_assoc` é usado para obter uma linha de resultado como um array associativo, onde os nomes das colunas são usados como chaves.

Exemplo:
```php
$serie = $resultado->fetch_assoc();
```

## Testando o CRUD

O arquivo `php/teste_crud.php` contém testes automatizados para verificar se todas as operações CRUD estão funcionando corretamente. Para executar os testes:

1. Certifique-se de que o banco de dados está configurado corretamente.
2. No terminal, execute:

```bash
php php/teste_crud.php
```

3. Verifique os resultados dos testes no terminal.

## Solução de Problemas

### Erro de Conexão com o Banco de Dados

- Verifique se o MySQL está em execução.
- Verifique se as credenciais no arquivo `php/conexao.php` estão corretas.
- Verifique se o banco de dados `cadastro_series` foi criado corretamente.


## Conclusão

Este sistema de Cadastro de Séries demonstra a implementação de um CRUD completo usando PHP com MySQL e Node.js. Ele utiliza prepared statements, bind_param e fetch_assoc para garantir segurança e eficiência nas operações de banco de dados.

Para qualquer dúvida ou problema, consulte a documentação ou entre em contato com o desenvolvedor.
