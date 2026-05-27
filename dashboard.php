<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
}

include 'config/conexao.php';

$animais = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM animais"));
$adotantes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM adotantes"));
$doacoes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM doacoes"));
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#0D0D0D;
    color:white;
}

.sidebar{
    width:250px;
    height:100vh;
    background:#111;
    position:fixed;
    padding:20px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:10px;
    margin-bottom:10px;
    border-radius:10px;
}

.sidebar a:hover{
    background:#0A3D91;
}

.content{
    margin-left:270px;
    padding:30px;
}

.card-dashboard{
    background:#151515;
    border:none;
    border-radius:20px;
    padding:20px;
    box-shadow:0 0 15px rgba(10,61,145,0.4);
}

</style>

</head>
<body>

<div class="sidebar">

    <h3>🐾 PetMatch</h3>

    <hr>

    <a href="dashboard.php">Dashboard</a>

    <a href="animais/listar.php">Animais</a>

    <a href="adotantes/listar.php">Adotantes</a>

    <a href="processos/listar.php">Processos</a>

    <a href="doacoes/listar.php">Doações</a>

    <a href="logout.php">Sair</a>

</div>

<div class="content">

    <h2>
        Bem-vinda, <?php echo $_SESSION['usuario']; ?> 💙
    </h2>

    <div class="row mt-4">

        <div class="col-md-4 mb-4">
            <div class="card-dashboard">
                <h5>🐶 Animais</h5>
                <h1><?php echo $animais; ?></h1>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card-dashboard">
                <h5>👤 Adotantes</h5>
                <h1><?php echo $adotantes; ?></h1>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card-dashboard">
                <h5>💰 Doações</h5>
                <h1><?php echo $doacoes; ?></h1>
            </div>
        </div>

    </div>

</div>

</body>
</html>