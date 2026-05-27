<?php
session_start();
include 'config/conexao.php';

if(isset($_POST['entrar'])){

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios 
            WHERE email='$email' 
            AND senha='$senha'";

    $resultado = mysqli_query($conn, $sql);

    if(mysqli_num_rows($resultado) > 0){

        $usuario = mysqli_fetch_assoc($resultado);

        $_SESSION['usuario'] = $usuario['nome'];

        header("Location: dashboard.php");

    } else {
        $erro = "Email ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">

<title>Login - PetMatch</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background: #0D0D0D;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card-login{
    width:400px;
    padding:40px;
    border-radius:20px;
    background:#151515;
    color:white;
    box-shadow:0 0 20px rgba(10,61,145,0.5);
}

.btn-login{
    background:#E8640A;
    border:none;
}

.btn-login:hover{
    background:#ff7b1f;
}

</style>

</head>
<body>

<div class="card-login">

    <h2 class="text-center mb-4">🐾 PetMatch</h2>

    <?php if(isset($erro)){ ?>

        <div class="alert alert-danger">
            <?php echo $erro; ?>
        </div>

    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Senha</label>
            <input type="password" name="senha" class="form-control">
        </div>

        <button type="submit" name="entrar" class="btn btn-login w-100">
            Entrar
        </button>

    </form>

</div>

</body>
</html>