<?php
session_start();
require "connection.php";

if ($_POST) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);

        if ($senha == $user['senha']) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            header("Location: painel.php");
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>
<link rel="stylesheet" href="style/style.css">

<div class="container">
    <h2>Login</h2>

    <?php if(isset($erro)) echo "<p style='color:red; text-align:center;'>$erro</p>"; ?>

    <form method="POST">
        <div class="input-box">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="input-box">
            <label>Senha</label>
            <input type="password" name="senha" required>
        </div>

        <button type="submit">Entrar</button>

        <div class="footer-link">
            Não tem conta? <a href="register.php">Cadastrar</a>
        </div>
    </form>
</div>
