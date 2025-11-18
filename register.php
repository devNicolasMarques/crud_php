<?php
require "connection.php";

if ($_POST) {
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "INSERT INTO usuarios (nome, email, senha)
            VALUES ('$nome', '$email', '$senha')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
        exit;
    } else {
        $erro = "Erro ao cadastrar!";
    }
}
?>
<link rel="stylesheet" href="style/style.css">

<div class="container">
    <h2>Cadastrar</h2>

    <?php if(isset($erro)) echo "<p style='color:red; text-align:center;'>$erro</p>"; ?>

    <form method="POST">
        <div class="input-box">
            <label>Nome</label>
            <input type="text" name="nome" required>
        </div>

        <div class="input-box">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="input-box">
            <label>Senha</label>
            <input type="password" name="senha" required>
        </div>

        <button type="submit">Cadastrar</button>

        <div class="footer-link">
            Já tem conta? <a href="login.php">Entrar</a>
        </div>
    </form>
</div>
