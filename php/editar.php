<?php
include("conexao.php");

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $genero = $_POST["genero"];
    $criador = $_POST["criador"];
    $ano_lancamento = $_POST["ano_lancamento"];
    $temporadas = $_POST["temporadas"];
    $sinopse = $_POST["sinopse"];
    $avaliacao = $_POST["avaliacao"];
    $status = $_POST["status"];

    $stmt = $conn->prepare("UPDATE series SET titulo = ?, genero = ?, criador = ?, ano_lancamento = ?, temporadas = ?, sinopse = ?, avaliacao = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssiisdsi", $titulo, $genero, $criador, $ano_lancamento, $temporadas, $sinopse, $avaliacao, $status, $id);
    $stmt->execute();

    header("Location: index.php");
}

$resultado = $conn->query("SELECT * FROM series WHERE id = $id");
$serie = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Séries</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Editar Série</h2>
<form method="post">
Título: <input type="text" name="titulo" value="<?= $serie['titulo'] ?>"><br>
Gênero: <input type="text" name="genero" value="<?= $serie['genero'] ?>"><br>
Criador: <input type="text" name="criador" value="<?= $serie['criador'] ?>"><br>
Ano de Lançamento: <input type="number" name="ano_lancamento" value="<?= $serie['ano_lancamento'] ?>"><br>
Temporadas: <input type="number" name="temporadas" value="<?= $serie['temporadas'] ?>"><br>
Sinopse: <textarea name="sinopse"><?= $serie['sinopse'] ?></textarea><br>
Avaliação: <input type="text" name="avaliacao" value="<?= $serie['avaliacao'] ?>"><br>
Status: <input type="text" name="status" value="<?= $serie['status'] ?>"><br>
<button type="submit">Atualizar</button>
</form>
    
</body>
</html>


