<?php

include '../config/conexao.php';

$id = $_GET['id'];

$sql = "SELECT * FROM animais WHERE id = $id";

$resultado = mysqli_query($conn, $sql);

$animal = mysqli_fetch_assoc($resultado);

if(isset($_POST['editar'])){

    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $sexo = $_POST['sexo'];
    $descricao = $_POST['descricao'];

    $update = "UPDATE animais SET

        nome='$nome',
        idade_categoria='$idade',
        sexo='$sexo',
        descricao='$descricao'

        WHERE id=$id";

    mysqli_query($conn, $update);

    header("Location: listar.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Editar Animal</title>

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

        <h2 class="mb-4">✏ Editar Animal</h2>

        <form method="POST">

            <div class="mb-3">

                <label>Nome</label>

                <input 
                type="text"
                name="nome"
                class="form-control"
                value="<?php echo $animal['nome']; ?>">

            </div>

            <div class="mb-3">

                <label>Idade</label>

                <select name="idade" class="form-select">

                    <option>Filhote</option>
                    <option>Jovem</option>
                    <option>Adulto</option>
                    <option>Idoso</option>

                </select>

            </div>

            <div class="mb-3">

                <label>Sexo</label>

                <select name="sexo" class="form-select">

                    <option>Macho</option>
                    <option>Femea</option>

                </select>

            </div>

            <div class="mb-4">

                <label>Descrição</label>

                <textarea 
                name="descricao"
                class="form-control"><?php echo $animal['descricao']; ?></textarea>

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