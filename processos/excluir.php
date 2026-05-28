<?php
session_start();
if(!isset($_SESSION['usuario'])){ header("Location: ../login.php"); exit(); }
include '../config/conexao.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM processos_adocao WHERE id = $id");
}
header("Location: listar.php");
exit();
?>