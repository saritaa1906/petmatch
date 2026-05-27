<?php

include '../config/conexao.php';

if(isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];

    $sql = "INSERT INTO adotantes
    (
        nome,
        email,
        telefone,
        cpf,
        endereco
    )
    VALUES
    (
        '$nome',
        '$email',
        '$telefone',
        '$cpf',
        '$endereco'
    )";

    mysqli_query($conn, $sql);

    header("Location: listar.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Cadastrar Adotante</title>

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

.btn-orange{
    background:#E8640A;
    color:white;
    border:none;
}

.btn-orange:hover{
    background:#ff7b1f;
}

</style>

</head>

<body>

<div class="container mt-5">

    <div class="card p-5">

        <h2 class="mb-4">👤 Novo Adotante</h2>

        <form method="POST">

            <div class="mb-3">

                <label>Nome</label>

                <input 
                type="text"
                name="nome"
                class="form-control"
                required>

            </div>

            <div class="mb-3">

                <label>Email</label>

                <input 
                type="email"
                name="email"
                class="form-control"
                required>

            </div>

            <div class="mb-3">

                <label>Telefone</label>

                <input 
                type="text"
                name="telefone"
                class="form-control">

            </div>

            <div class="mb-3">

                <label>CPF</label>

                <input 
                type="text"
                name="cpf"
                class="form-control">

            </div>

            <div class="mb-4">

                <label>Endereço</label>

                <textarea 
                name="endereco"
                class="form-control"
                rows="3"></textarea>

            </div>

            <button 
            type="submit"
            name="cadastrar"
            class="btn btn-orange">

                Salvar

            </button>

        </form>

    </div>

</div>

</body>
</html>