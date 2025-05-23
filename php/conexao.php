<?php
// Arquivo de conexão com o banco de dados
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'cadastro_series';

// Estabelece a conexão com o banco de dados
function conectarBD() {
    global $host, $usuario, $senha, $banco;
    
    $conexao = new mysqli($host, $usuario, $senha, $banco);
    
    // Verifica se houve erro na conexão
    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }
    
    // Define o charset para utf8
    $conexao->set_charset("utf8");
    
    return $conexao;
}

// Fecha a conexão com o banco de dados
function fecharConexao($conexao) {
    $conexao->close();
}
