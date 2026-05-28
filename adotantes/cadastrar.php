<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include '../config/conexao.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = "INSERT INTO adotantes (nome, email) VALUES ('$nome', '$email')";
    
    if(mysqli_query($conn, $sql)){
        header("Location: listar.php");
        exit();
    } else {
        $erro = "Erro ao cadastrar: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Adotante - PetMatch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0D0D0D; color: white; font-family: 'Segoe UI', sans-serif; }
        .container-custom { max-width: 600px; margin: 50px auto; }
        .page-header { border-bottom: 2px solid #0A3D91; padding-bottom: 15px; margin-bottom: 30px; text-align: center;}
        .page-header h2 { margin: 0; font-weight: bold; color: #f8f9fa; }
        .page-header h2 span { color: #4A90E2; }
        .form-wrapper { background: #151515; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(10, 61, 145, 0.15); }
        .form-label { color: #ccc; font-weight: 500;}
        .form-control { background-color: #1a1a1a; border: 1px solid #333; color: white; border-radius: 8px;}
        .form-control:focus { background-color: #222; border-color: #4A90E2; box-shadow: 0 0 10px rgba(74, 144, 226, 0.3); color: white;}
        .btn-salvar { background: #0A3D91; color: white; border: none; border-radius: 8px; padding: 10px 20px; font-weight: bold; width: 100%; transition: 0.3s; }
        .btn-salvar:hover { background: #4A90E2; color: white; }
        .btn-voltar { background: #222; color: white; border: 1px solid #444; border-radius: 8px; padding: 10px 20px; text-decoration: none; width: 100%; display: block; text-align: center; margin-top: 10px; transition: 0.3s; }
        .btn-voltar:hover { background: #333; color: white; }
    </style>
</head>
<body>

<div class="container container-custom">
    <div class="page-header">
        <h2>👤 Cadastrar <span>Adotante</span></h2>
    </div>

    <div class="form-wrapper">
        <?php if(isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Nome Completo</label>
                <input type="text" name="nome" class="form-control" placeholder="Ex: João da Silva" required>
            </div>

            <div class="mb-4">
                <label class="form-label">E-mail de Contato</label>
                <input type="email" name="email" class="form-control" placeholder="Ex: joao@email.com" required>
            </div>

            <button type="submit" class="btn-salvar">Salvar Cadastro</button>
            <a href="listar.php" class="btn-voltar">Cancelar e Voltar</a>
        </form>
    </div>
</div>

</body>
</html>