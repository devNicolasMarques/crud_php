<?php

$server = "localhost";
$user = "root";
$password = "root";
$database = "aula_php";
$port = 3307;

$conn = mysqli_connect($server, $user, $password, $database, $port);

if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}
?>