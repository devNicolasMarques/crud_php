<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>

<h2>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h2>
<a href="logout.php">Sair</a>
