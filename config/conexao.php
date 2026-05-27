<?php

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db = "petmatch";
$porta = 3307;

$conn = mysqli_connect($host, $user, $pass, $db, $porta);

if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}

?>