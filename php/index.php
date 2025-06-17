<?php
include("conexao.php");

$resultado = $conn->query("SELECT * FROM series ORDER BY titulo");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Séries</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2>Cadastro de Séries</h2>

<a href="inserir.php">+ Nova Série</a>

<table border="1">
<tr><th>ID</th><th>Título</th><th>Gênero</th><th>Ano</th><th>Ações</th></tr>
<?php while ($linha = $resultado->fetch_assoc()): ?>
<tr>
    <td><?= $linha["id"] ?></td>
    <td><?= $linha["titulo"] ?></td>
    <td><?= $linha["genero"] ?></td>
    <td><?= $linha["ano_lancamento"] ?></td>
    <td>
        <a href="editar.php?id=<?= $linha["id"] ?>">Editar</a> |
        <a href="excluir.php?id=<?= $linha["id"] ?>" onclick="return confirm('Deseja excluir?')">Excluir</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

<script src="js/script.js"></script>
</body>
</html>
