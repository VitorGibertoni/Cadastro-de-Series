<?php
include("conexao.php");

// Verifica se há termo de busca
$termo = isset($_GET["pesquisa"]) ? $_GET["pesquisa"] : "";

// Consulta com filtro, se houver
if (!empty($termo)) {
    $termo_sql = "%" . $conn->real_escape_string($termo) . "%";
    $stmt = $conn->prepare("SELECT * FROM series WHERE titulo LIKE ? ORDER BY titulo");
    $stmt->bind_param("s", $termo_sql);
    $stmt->execute();
    $resultado = $stmt->get_result();
} else {
    $resultado = $conn->query("SELECT * FROM series ORDER BY titulo");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Séries</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">

    <h2>Cadastro de Séries</h2>

    <a class="botao" href="inserir.php">+ Nova Série</a>

    <div class="pesquisa">
        <h3>Pesquisar Séries</h3>
        <form method="get" class="campo-pesquisa">
            <input type="text" name="pesquisa" placeholder="Digite o título da série..." value="<?= htmlspecialchars($termo) ?>">
            <button type="submit">Pesquisar</button>
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Gênero</th>
            <th>Criador</th>
            <th>Ano</th>
            <th>Temporadas</th>
            <th>Sinopse</th>
            <th>Avaliação</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <?php while ($linha = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $linha["id"] ?></td>
            <td><?= $linha["titulo"] ?></td>
            <td><?= $linha["genero"] ?></td>
            <td><?= $linha["criador"] ?></td>
            <td><?= $linha["ano_lancamento"] ?></td>
            <td><?= $linha["temporadas"] ?></td>
            <td><?= $linha["sinopse"] ?></td>
            <td><?= $linha["avaliacao"] ?></td>
            <td><?= $linha["status"] ?></td>
            <td>
                <a class="botao-editar" href="editar.php?id=<?= $linha["id"] ?>">Editar</a>
                <a class="botao-excluir" href="excluir.php?id=<?= $linha["id"] ?>" onclick="return confirm('Deseja excluir?')">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</div>
<script src="js/script.js"></script>
</body>
</html>
