<?php

include '../config/conexao.php';

if(isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $idade = $_POST['idade'];
    $sexo = $_POST['sexo'];
    $descricao = $_POST['descricao'];

    $sql = "INSERT INTO animais
    (
        nome,
        especie_id,
        idade_categoria,
        sexo,
        descricao,
        status_adocao,
        data_cadastro
    )
    VALUES
    (
        '$nome',
        '$especie',
        '$idade',
        '$sexo',
        '$descricao',
        'Disponivel',
        CURDATE()
    )";

    mysqli_query($conn, $sql);

    header("Location: listar.php");
}

$especies = mysqli_query($conn, "SELECT * FROM especies_racas");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Cadastrar Animal</title>

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

        <h2 class="mb-4">🐾 Cadastrar Animal</h2>

        <form method="POST">

            <div class="mb-3">

                <label>Nome do Animal</label>

                <input 
                type="text" 
                name="nome" 
                class="form-control"
                required>

            </div>

            <div class="mb-3">

                <label>Espécie</label>

                <select 
                name="especie" 
                class="form-select">

                    <?php while($e = mysqli_fetch_assoc($especies)){ ?>

                        <option value="<?php echo $e['id']; ?>">

                            <?php echo $e['nome']; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="mb-3">

                <label>Idade</label>

                <select 
                name="idade" 
                class="form-select">

                    <option>Filhote</option>
                    <option>Jovem</option>
                    <option>Adulto</option>
                    <option>Idoso</option>

                </select>

            </div>

            <div class="mb-3">

                <label>Sexo</label>

                <select 
                name="sexo" 
                class="form-select">

                    <option>Macho</option>
                    <option>Femea</option>

                </select>

            </div>

            <div class="mb-4">

                <label>Descrição</label>

                <textarea 
                name="descricao" 
                class="form-control"
                rows="4"></textarea>

            </div>

            <button 
            type="submit" 
            name="cadastrar" 
            class="btn btn-orange">

                Salvar Animal

            </button>

        </form>

    </div>

</div>

</body>
</html>