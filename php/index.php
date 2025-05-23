<?php
// Inclui o arquivo com as funções CRUD
require_once 'crud_series.php';

// Inicializa a variável de mensagem
$mensagem = '';

// Verifica se o formulário foi enviado para criar ou atualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $criador = $_POST['criador'];
    $ano_lancamento = $_POST['ano_lancamento'];
    $temporadas = $_POST['temporadas'];
    $sinopse = $_POST['sinopse'];
    $avaliacao = $_POST['avaliacao'];
    $status = $_POST['status'];
    
    // Verifica se é uma atualização ou criação
    if ($id) {
        // Atualiza a série existente
        if (atualizarSerie($id, $titulo, $genero, $criador, $ano_lancamento, $temporadas, $sinopse, $avaliacao, $status)) {
            $mensagem = "Série atualizada com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar série.";
        }
    } else {
        // Cria uma nova série
        if (criarSerie($titulo, $genero, $criador, $ano_lancamento, $temporadas, $sinopse, $avaliacao, $status)) {
            $mensagem = "Série cadastrada com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar série.";
        }
    }
}

// Verifica se foi solicitada a exclusão de uma série
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    
    if (excluirSerie($id)) {
        $mensagem = "Série excluída com sucesso!";
    } else {
        $mensagem = "Erro ao excluir série.";
    }
}

// Verifica se foi solicitada a edição de uma série
$serie_edicao = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $serie_edicao = buscarSeriePorId($id);
}

// Verifica se foi solicitada uma pesquisa
$series = [];
if (isset($_GET['pesquisar']) && !empty($_GET['termo'])) {
    $termo = $_GET['termo'];
    $series = buscarSeriesPorTitulo($termo);
} else {
    // Lista todas as séries
    $series = listarSeries();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Séries</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Cadastro de Séries</h1>
        
        <?php if (!empty($mensagem)): ?>
            <div class="mensagem">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>
        
        <div class="formulario">
            <h2><?php echo $serie_edicao ? 'Editar Série' : 'Nova Série'; ?></h2>
            <form method="POST" action="index.php">
                <?php if ($serie_edicao): ?>
                    <input type="hidden" name="id" value="<?php echo $serie_edicao['id']; ?>">
                <?php endif; ?>
                
                <div class="campo">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required 
                           value="<?php echo $serie_edicao ? $serie_edicao['titulo'] : ''; ?>">
                </div>
                
                <div class="campo">
                    <label for="genero">Gênero:</label>
                    <input type="text" id="genero" name="genero" required 
                           value="<?php echo $serie_edicao ? $serie_edicao['genero'] : ''; ?>">
                </div>
                
                <div class="campo">
                    <label for="criador">Criador:</label>
                    <input type="text" id="criador" name="criador" required 
                           value="<?php echo $serie_edicao ? $serie_edicao['criador'] : ''; ?>">
                </div>
                
                <div class="campo">
                    <label for="ano_lancamento">Ano de Lançamento:</label>
                    <input type="number" id="ano_lancamento" name="ano_lancamento" required 
                           value="<?php echo $serie_edicao ? $serie_edicao['ano_lancamento'] : ''; ?>">
                </div>
                
                <div class="campo">
                    <label for="temporadas">Temporadas:</label>
                    <input type="number" id="temporadas" name="temporadas" required 
                           value="<?php echo $serie_edicao ? $serie_edicao['temporadas'] : ''; ?>">
                </div>
                
                <div class="campo">
                    <label for="sinopse">Sinopse:</label>
                    <textarea id="sinopse" name="sinopse" rows="4"><?php echo $serie_edicao ? $serie_edicao['sinopse'] : ''; ?></textarea>
                </div>
                
                <div class="campo">
                    <label for="avaliacao">Avaliação (0-10):</label>
                    <input type="number" id="avaliacao" name="avaliacao" step="0.1" min="0" max="10" required 
                           value="<?php echo $serie_edicao ? $serie_edicao['avaliacao'] : ''; ?>">
                </div>
                
                <div class="campo">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="">Selecione...</option>
                        <option value="Em andamento" <?php echo ($serie_edicao && $serie_edicao['status'] == 'Em andamento') ? 'selected' : ''; ?>>Em andamento</option>
                        <option value="Finalizada" <?php echo ($serie_edicao && $serie_edicao['status'] == 'Finalizada') ? 'selected' : ''; ?>>Finalizada</option>
                        <option value="Cancelada" <?php echo ($serie_edicao && $serie_edicao['status'] == 'Cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                </div>
                
                <div class="botoes">
                    <button type="submit"><?php echo $serie_edicao ? 'Atualizar' : 'Cadastrar'; ?></button>
                    <?php if ($serie_edicao): ?>
                        <a href="index.php" class="botao">Cancelar</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="pesquisa">
            <h2>Pesquisar Séries</h2>
            <form method="GET" action="index.php">
                <div class="campo-pesquisa">
                    <input type="text" name="termo" placeholder="Digite o título da série..." 
                           value="<?php echo isset($_GET['termo']) ? $_GET['termo'] : ''; ?>">
                    <button type="submit" name="pesquisar" value="1">Pesquisar</button>
                </div>
            </form>
        </div>
        
        <div class="listagem">
            <h2>Séries Cadastradas</h2>
            
            <?php if (empty($series)): ?>
                <p>Nenhuma série encontrada.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Gênero</th>
                            <th>Criador</th>
                            <th>Ano</th>
                            <th>Temporadas</th>
                            <th>Avaliação</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($series as $serie): ?>
                            <tr>
                                <td><?php echo $serie['titulo']; ?></td>
                                <td><?php echo $serie['genero']; ?></td>
                                <td><?php echo $serie['criador']; ?></td>
                                <td><?php echo $serie['ano_lancamento']; ?></td>
                                <td><?php echo $serie['temporadas']; ?></td>
                                <td><?php echo $serie['avaliacao']; ?></td>
                                <td><?php echo $serie['status']; ?></td>
                                <td>
                                    <a href="index.php?editar=<?php echo $serie['id']; ?>" class="botao-editar">Editar</a>
                                    <a href="index.php?excluir=<?php echo $serie['id']; ?>" class="botao-excluir" 
                                       onclick="return confirm('Tem certeza que deseja excluir esta série?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="../js/script.js"></script>
</body>
</html>
