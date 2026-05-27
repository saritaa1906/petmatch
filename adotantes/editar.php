<?php

include '../config/conexao.php';

$id = $_GET['id'];

$sql = "SELECT * FROM adotantes WHERE id = $id";

$resultado = mysqli_query($conn, $sql);

$adotante = mysqli_fetch_assoc($resultado);

if(isset($_POST['editar'])){

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];

    $update = "UPDATE adotantes SET

        nome='$nome',
        email='$email',
        telefone='$telefone',
        cpf='$cpf',
        endereco='$endereco'

        WHERE id=$id";

    mysqli_query($conn, $update);

    header("Location: listar.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Editar Adotante</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#0D0D0D;
    color:white;
}

.card{
    background:#151515;
    border:none;
    border-radius:20px;
    color:white;
}

</style>

</head>

<body>

<div class="container mt-5">

    <div class="card p-5">

        <h2 class="mb-4">✏ Editar Adotante</h2>

        <form method="POST">

            <div class="mb-3">

                <label>Nome</label>

                <input 
                type="text"
                name="nome"
                class="form-control"
                value="<?php echo $adotante['nome']; ?>">

            </div>

            <div class="mb-3">

                <label>Email</label>

                <input 
                type="email"
                name="email"
                class="form-control"
                value="<?php echo $adotante['email']; ?>">

            </div>

            <div class="mb-3">

                <label>Telefone</label>

                <input 
                type="text"
                name="telefone"
                class="form-control"
                value="<?php echo $adotante['telefone']; ?>">

            </div>

            <div class="mb-3">

                <label>CPF</label>

                <input 
                type="text"
                name="cpf"
                class="form-control"
                value="<?php echo $adotante['cpf']; ?>">

            </div>

            <div class="mb-4">

                <label>Endereço</label>

                <textarea 
                name="endereco"
                class="form-control"><?php echo $adotante['endereco']; ?></textarea>

            </div>

            <button 
            type="submit"
            name="editar"
            class="btn btn-warning">

                Atualizar

            </button>

        </form>

    </div>

</div>

</body>
</html>