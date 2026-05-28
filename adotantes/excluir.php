<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include '../config/conexao.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    $sql = "DELETE FROM adotantes WHERE id = $id";
    mysqli_query($conn, $sql);
}

header("Location: listar.php");
exit();
?>