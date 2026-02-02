<?php

$server = "localhost";
$user = "root";
$password = "root";
$database = "aula";
$port = "3307";

$conn = new mysqli($server, $user, $password, $database, $port);

if($conn->connect_error){
    echo "Erro"; 
}
else{
    echo "Conectado com sucesso!";
}
