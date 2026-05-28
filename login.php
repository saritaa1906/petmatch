<?php
session_start();
include 'config/conexao.php';

// Se o usuário já estiver logado, manda direto para a home
if(isset($_SESSION['usuario'])){
    header("Location: home.php");
    exit();
}

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

        header("Location: home.php");
        exit();

    } else {
        $erro = "Email ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PetMatch</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #0D0D0D;
            overflow: hidden;
        }

        /* Container que divide a tela */
        .login-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* LADO ESQUERDO: A imagem do pôr do sol com a logo livre */
        .login-image-side {
            flex: 2;
            background-image: linear-gradient(to left, #111111, rgba(13, 13, 13, 0.1)), url('assets/img/bg-login.png');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        /* LADO DIREITO: Onde fica a caixa centralizada */
        .login-form-side {
            flex: 1;
            max-width: 500px;
            background: #111111;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            border-left: 1px solid #222; /* Bordinha sutil divisória */
            z-index: 2;
        }

        /* A Caixa de Login discreta e sem sombras exageradas */
        .card-login-custom {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            color: white;
        }

        .brand-logo {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            text-align: center;
        }
        .brand-logo span { color: #E8640A; }

        .form-control {
            background-color: #151515 !important;
            border: 1px solid #333 !important;
            color: white !important;
            border-radius: 12px;
            padding: 12px 15px;
        }
        .form-control:focus {
            border-color: #E8640A !important;
            box-shadow: 0 0 8px rgba(232, 100, 10, 0.2) !important;
        }

        .input-group-text {
            background-color: #151515 !important;
            border: 1px solid #333 !important;
            color: #666;
            border-radius: 12px 0 0 12px;
        }

        .btn-login {
            background: #E8640A;
            color: white;
            font-weight: 600;
            padding: 14px;
            border-radius: 12px;
            border: none;
            width: 100%;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: #ff7b1f;
            color: white;
        }

        label {
            color: #aaa;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        /* Celular joga o formulário para a tela cheia */
        @media (max-width: 768px) {
            .login-image-side { display: none; }
            .login-form-side { max-width: 100%; }
        }
    </style>
</head>
<body>

    <div class="login-container">
        
        <div class="login-image-side"></div>
        
        <div class="login-form-side">
            
            <div class="card-login-custom">
                
                <a href="#" class="brand-logo">🐾 Pet<span>Match</span></a>
                
                <p class="text-secondary text-center small mb-4">Painel Administrativo</p>

                <?php if(isset($erro)){ ?>
                    <div class="alert alert-danger border-0 small text-center mb-4" style="background: #2c1a1d; color: #ff8591; border-radius: 10px;">
                        <i class="fa-solid fa-triangle-exclamation"></i> <?php echo $erro; ?>
                    </div>
                <?php } ?>

                <form method="POST">
                    
                    <div class="mb-3">
                        <label>Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" style="border-radius: 0 12px 12px 0;" placeholder="exemplo@email.com" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label>Senha</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="senha" class="form-control" style="border-radius: 0 12px 12px 0;" placeholder="Sua senha" required>
                        </div>
                    </div>

                    <button type="submit" name="entrar" class="btn btn-login w-100">
                        <i class="fa-solid fa-right-to-bracket me-2"></i> Entrar
                    </button>

                </form>

            </div>

        </div>

    </div>

</body>
</html>