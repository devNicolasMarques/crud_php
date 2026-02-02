<?php

include_once "connection.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$senha_criptografada = md5($senha);

$sql = "INSERT INTO usuario(nome, email, senha) VALUES ('$nome','$email', '$senha_criptografada')"; 

if(mysqli_query($conn, $sql)){
    return true;
}
else{
    return false;
}





?>