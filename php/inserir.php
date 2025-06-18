<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $genero = $_POST["genero"];
    $criador = $_POST["criador"];
    $ano_lancamento = $_POST["ano_lancamento"];
    $temporadas = $_POST["temporadas"];
    $sinopse = $_POST["sinopse"];
    $avaliacao = $_POST["avaliacao"];
    $status = $_POST["status"];

    $stmt = $conn->prepare("INSERT INTO series (titulo, genero, criador, ano_lancamento, temporadas, sinopse, avaliacao, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiisds", $titulo, $genero, $criador, $ano_lancamento, $temporadas, $sinopse, $avaliacao, $status);
    $stmt->execute();

    header("Location: index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Séries</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="container">
     <h2>Inserir Série</h2>
<form method="post">
Título: <input type="text" name="titulo"><br>
Gênero: <input type="text" name="genero"><br>
Criador: <input type="text" name="criador"><br>
Ano de Lançamento: <input type="number" name="ano_lancamento"><br>
Temporadas: <input type="number" name="temporadas"><br>
Sinopse: <textarea name="sinopse"></textarea><br>
Avaliação: <input type="text" name="avaliacao"><br>
Status: <input type="text" name="status"><br>
<button type="submit">Salvar</button>
</form> 
  </div>
</body>
</html>


