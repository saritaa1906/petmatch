<?php
session_start();
include '../../config/conexao.php'; // Os dois pontos (../../) servem para subir as pastas e achar o config

$sql = "SELECT * FROM adotantes"; 
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Adotantes</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#0D0D0D;
    color:white;
}

.container{
    margin-top:50px;
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

        <h1>👤 Lista de Adotantes</h1>

        <a href="cadastrar.php" class="btn btn-orange">
            + Novo Adotante
        </a>

    </div>

    <table class="table table-dark table-hover">

        <thead>

            <tr>

                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>

            </tr>

        </thead>

        <tbody>

            <?php while($adotante = mysqli_fetch_assoc($resultado)){ ?>

                <tr>

                    <td><?php echo $adotante['id']; ?></td>

                    <td><?php echo $adotante['nome']; ?></td>

                    <td><?php echo $adotante['email']; ?></td>

                    <td><?php echo $adotante['telefone']; ?></td>

                    <td>

                        <a 
                        href="editar.php?id=<?php echo $adotante['id']; ?>" 
                        class="btn btn-primary btn-sm">

                            Editar

                        </a>

                        <a 
                        href="excluir.php?id=<?php echo $adotante['id']; ?>" 
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