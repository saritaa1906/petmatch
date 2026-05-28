<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include '../config/conexao.php';

// Verifica se foi passado um ID na URL
if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // Deleta o animal do banco
    $sql = "DELETE FROM animais WHERE id = $id";
    mysqli_query($conn, $sql);
}

// Redireciona de volta para a tabela
header("Location: listar.php");
exit();
?>