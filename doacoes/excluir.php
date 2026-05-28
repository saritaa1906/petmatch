<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../voluntarios/login.php"); exit(); }

require_once '../config/conexao.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM doacoes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: listar.php");
exit();