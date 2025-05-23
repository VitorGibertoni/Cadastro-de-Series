<?php
// Inclui o arquivo de conexão
require_once 'conexao.php';

// Função para criar (inserir) uma nova série
function criarSerie($titulo, $genero, $criador, $ano_lancamento, $temporadas, $sinopse, $avaliacao, $status) {
    $conexao = conectarBD();
    
    $sql = "INSERT INTO series (titulo, genero, criador, ano_lancamento, temporadas, sinopse, avaliacao, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepara a consulta
    $stmt = $conexao->prepare($sql);
    
    // Verifica se a preparação foi bem-sucedida
    if (!$stmt) {
        fecharConexao($conexao);
        return false;
    }
    
    // Vincula os parâmetros
    $stmt->bind_param("sssiisds", $titulo, $genero, $criador, $ano_lancamento, $temporadas, $sinopse, $avaliacao, $status);
    
    // Executa a consulta
    $resultado = $stmt->execute();
    
    // Fecha o statement
    $stmt->close();
    
    // Fecha a conexão
    fecharConexao($conexao);
    
    return $resultado;
}

// Função para ler (consultar) todas as séries
function listarSeries() {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM series ORDER BY titulo";
    
    // Prepara a consulta
    $stmt = $conexao->prepare($sql);
    
    // Verifica se a preparação foi bem-sucedida
    if (!$stmt) {
        fecharConexao($conexao);
        return false;
    }
    
    // Executa a consulta
    $stmt->execute();
    
    // Obtém o resultado
    $resultado = $stmt->get_result();
    
    $series = [];
    
    // Percorre os resultados e armazena em um array
    while ($serie = $resultado->fetch_assoc()) {
        $series[] = $serie;
    }
    
    // Fecha o statement
    $stmt->close();
    
    // Fecha a conexão
    fecharConexao($conexao);
    
    return $series;
}

// Função para ler (consultar) uma série específica pelo ID
function buscarSeriePorId($id) {
    $conexao = conectarBD();
    
    $sql = "SELECT * FROM series WHERE id = ?";
    
    // Prepara a consulta
    $stmt = $conexao->prepare($sql);
    
    // Verifica se a preparação foi bem-sucedida
    if (!$stmt) {
        fecharConexao($conexao);
        return false;
    }
    
    // Vincula os parâmetros
    $stmt->bind_param("i", $id);
    
    // Executa a consulta
    $stmt->execute();
    
    // Obtém o resultado
    $resultado = $stmt->get_result();
    
    // Obtém a série
    $serie = $resultado->fetch_assoc();
    
    // Fecha o statement
    $stmt->close();
    
    // Fecha a conexão
    fecharConexao($conexao);
    
    return $serie;
}

// Função para atualizar uma série existente
function atualizarSerie($id, $titulo, $genero, $criador, $ano_lancamento, $temporadas, $sinopse, $avaliacao, $status) {
    $conexao = conectarBD();
    
    $sql = "UPDATE series SET titulo = ?, genero = ?, criador = ?, ano_lancamento = ?, 
            temporadas = ?, sinopse = ?, avaliacao = ?, status = ? WHERE id = ?";
    
    // Prepara a consulta
    $stmt = $conexao->prepare($sql);
    
    // Verifica se a preparação foi bem-sucedida
    if (!$stmt) {
        fecharConexao($conexao);
        return false;
    }
    
    // Vincula os parâmetros
    $stmt->bind_param("sssiisdsi", $titulo, $genero, $criador, $ano_lancamento, $temporadas, $sinopse, $avaliacao, $status, $id);

    
    // Executa a consulta
    $resultado = $stmt->execute();
    
    // Fecha o statement
    $stmt->close();
    
    // Fecha a conexão
    fecharConexao($conexao);
    
    return $resultado;
}

// Função para excluir uma série
function excluirSerie($id) {
    $conexao = conectarBD();
    
    $sql = "DELETE FROM series WHERE id = ?";
    
    // Prepara a consulta
    $stmt = $conexao->prepare($sql);
    
    // Verifica se a preparação foi bem-sucedida
    if (!$stmt) {
        fecharConexao($conexao);
        return false;
    }
    
    // Vincula os parâmetros
    $stmt->bind_param("i", $id);
    
    // Executa a consulta
    $resultado = $stmt->execute();
    
    // Fecha o statement
    $stmt->close();
    
    // Fecha a conexão
    fecharConexao($conexao);
    
    return $resultado;
}

// Função para buscar séries por título (pesquisa parcial)
function buscarSeriesPorTitulo($termo) {
    $conexao = conectarBD();
    
    $termo = "%$termo%"; // Adiciona wildcards para busca parcial
    
    $sql = "SELECT * FROM series WHERE titulo LIKE ? ORDER BY titulo";
    
    // Prepara a consulta
    $stmt = $conexao->prepare($sql);
    
    // Verifica se a preparação foi bem-sucedida
    if (!$stmt) {
        fecharConexao($conexao);
        return false;
    }
    
    // Vincula os parâmetros
    $stmt->bind_param("s", $termo);
    
    // Executa a consulta
    $stmt->execute();
    
    // Obtém o resultado
    $resultado = $stmt->get_result();
    
    $series = [];
    
    // Percorre os resultados e armazena em um array
    while ($serie = $resultado->fetch_assoc()) {
        $series[] = $serie;
    }
    
    // Fecha o statement
    $stmt->close();
    
    // Fecha a conexão
    fecharConexao($conexao);
    
    return $series;
}
