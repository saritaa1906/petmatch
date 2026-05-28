<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../voluntarios/login.php"); exit(); }
include '../config/conexao.php';

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Busca o usuário para checar segurança
    $busca = mysqli_query($conn, "SELECT usuario FROM voluntarios WHERE id = $id");
    $vol = mysqli_fetch_assoc($busca);
    
    // Trava de segurança extra: impede deletar a si mesmo direto pela URL
    if($vol && $vol['usuario'] != $_SESSION['usuario']) {
        $sql = "DELETE FROM voluntarios WHERE id = $id";
        mysqli_query($conn, $sql);
    }
}

header("Location: listar.php");
exit();
?>