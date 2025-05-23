<?php
// Arquivo para testar a conexão com o banco de dados e validar o CRUD

// Inclui o arquivo de conexão
require_once 'conexao.php';

// Testa a conexão com o banco de dados
function testarConexao() {
    try {
        $conexao = conectarBD();
        echo "Conexão com o banco de dados estabelecida com sucesso!\n";
        fecharConexao($conexao);
        return true;
    } catch (Exception $e) {
        echo "Erro ao conectar com o banco de dados: " . $e->getMessage() . "\n";
        return false;
    }
}

// Testa a criação de uma série
function testarCriarSerie() {
    require_once 'crud_series.php';
    
    $titulo = "Série de Teste";
    $genero = "Teste";
    $criador = "Testador";
    $ano_lancamento = 2023;
    $temporadas = 1;
    $sinopse = "Esta é uma série de teste para validar o CRUD.";
    $avaliacao = 8.5;
    $status = "Em andamento";
    
    $resultado = criarSerie($titulo, $genero, $criador, $ano_lancamento, $temporadas, $sinopse, $avaliacao, $status);
    
    if ($resultado) {
        echo "Teste de criação de série: SUCESSO\n";
        return true;
    } else {
        echo "Teste de criação de série: FALHA\n";
        return false;
    }
}

// Testa a listagem de séries
function testarListarSeries() {
    require_once 'crud_series.php';
    
    $series = listarSeries();
    
    if (is_array($series)) {
        echo "Teste de listagem de séries: SUCESSO (Encontradas " . count($series) . " séries)\n";
        return true;
    } else {
        echo "Teste de listagem de séries: FALHA\n";
        return false;
    }
}

// Testa a busca de série por ID
function testarBuscarSeriePorId($id) {
    require_once 'crud_series.php';
    
    $serie = buscarSeriePorId($id);
    
    if ($serie) {
        echo "Teste de busca de série por ID: SUCESSO (Série: " . $serie['titulo'] . ")\n";
        return true;
    } else {
        echo "Teste de busca de série por ID: FALHA\n";
        return false;
    }
}

// Testa a atualização de uma série
function testarAtualizarSerie($id) {
    require_once 'crud_series.php';
    
    $serie = buscarSeriePorId($id);
    
    if (!$serie) {
        echo "Teste de atualização de série: FALHA (Série não encontrada)\n";
        return false;
    }
    
    $titulo = $serie['titulo'] . " (Atualizado)";
    $genero = $serie['genero'];
    $criador = $serie['criador'];
    $ano_lancamento = $serie['ano_lancamento'];
    $temporadas = $serie['temporadas'];
    $sinopse = $serie['sinopse'] . " Esta série foi atualizada para teste.";
    $avaliacao = $serie['avaliacao'];
    $status = $serie['status'];
    
    $resultado = atualizarSerie($id, $titulo, $genero, $criador, $ano_lancamento, $temporadas, $sinopse, $avaliacao, $status);
    
    if ($resultado) {
        echo "Teste de atualização de série: SUCESSO\n";
        return true;
    } else {
        echo "Teste de atualização de série: FALHA\n";
        return false;
    }
}

// Testa a exclusão de uma série
function testarExcluirSerie($id) {
    require_once 'crud_series.php';
    
    $resultado = excluirSerie($id);
    
    if ($resultado) {
        echo "Teste de exclusão de série: SUCESSO\n";
        return true;
    } else {
        echo "Teste de exclusão de série: FALHA\n";
        return false;
    }
}

// Executa os testes
echo "Iniciando testes do CRUD de Séries...\n\n";

$conexao_ok = testarConexao();

if ($conexao_ok) {
    $criar_ok = testarCriarSerie();
    $listar_ok = testarListarSeries();
    
    // Obtém o ID da última série para testar as outras operações
    $series = listarSeries();
    $ultimo_id = end($series)['id'];
    
    $buscar_ok = testarBuscarSeriePorId($ultimo_id);
    $atualizar_ok = testarAtualizarSerie($ultimo_id);
    $excluir_ok = testarExcluirSerie($ultimo_id);
    
    echo "\nResumo dos testes:\n";
    echo "- Conexão: " . ($conexao_ok ? "OK" : "FALHA") . "\n";
    echo "- Criar: " . ($criar_ok ? "OK" : "FALHA") . "\n";
    echo "- Listar: " . ($listar_ok ? "OK" : "FALHA") . "\n";
    echo "- Buscar: " . ($buscar_ok ? "OK" : "FALHA") . "\n";
    echo "- Atualizar: " . ($atualizar_ok ? "OK" : "FALHA") . "\n";
    echo "- Excluir: " . ($excluir_ok ? "OK" : "FALHA") . "\n";
    
    if ($conexao_ok && $criar_ok && $listar_ok && $buscar_ok && $atualizar_ok && $excluir_ok) {
        echo "\nTodos os testes foram concluídos com SUCESSO!\n";
    } else {
        echo "\nAlguns testes FALHARAM. Verifique os detalhes acima.\n";
    }
} else {
    echo "\nNão foi possível continuar os testes devido a falha na conexão com o banco de dados.\n";
}
