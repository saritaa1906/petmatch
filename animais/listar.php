<?php
session_start();
include '../../config/conexao.php'; 

$sql = "SELECT * FROM animais"; 
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Lista de Animais</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#0D0D0D;
    color:white;
}

.container{
    margin-top:50px;
}

.table{
    border-radius:15px;
    overflow:hidden;
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

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>🐶 Lista de Animais</h1>

        <a href="cadastrar.php" class="btn btn-orange">
            + Cadastrar Animal
        </a>

    </div>

    <table class="table table-dark table-hover">

        <thead>

            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Espécie</th>
                <th>Sexo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>

        </thead>

        <tbody>

            <?php while($animal = mysqli_fetch_assoc($resultado)){ ?>

                <tr>

                    <td><?php echo $animal['id']; ?></td>

                    <td><?php echo $animal['nome']; ?></td>

                    <td><?php echo $animal['especie']; ?></td>

                    <td><?php echo $animal['sexo']; ?></td>

                    <td><?php echo $animal['status_adocao']; ?></td>

                    <td>

                        <a 
                        href="editar.php?id=<?php echo $animal['id']; ?>" 
                        class="btn btn-primary btn-sm">

                            Editar

                        </a>

                        <a 
                        href="excluir.php?id=<?php echo $animal['id']; ?>" 
                        class="btn btn-danger btn-sm">

                            Excluir

                        </a>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>