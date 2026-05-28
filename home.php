<?php
session_start();

// Proteção: Se não estiver logado, volta para o login
if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

include 'config/conexao.php';
$nome_exibicao = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao PetMatch</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #0D0D0D;
            background-image: url('assets/img/bg-paws.png'); 
            background-repeat: repeat;
            color: white;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar minimalista superior */
        .home-nav {
            background: #111;
            padding: 15px 30px;
            border-bottom: 1px solid #222;
        }
        .logo-brand {
            font-weight: bold;
            font-size: 1.4rem;
            color: white;
            text-decoration: none;
        }
        .logo-brand span { color: #E8640A; }

        /* Banner de Boas-Vindas */
        .welcome-hero {
            text-align: center;
            padding: 60px 20px 40px 20px;
        }
        .welcome-hero h1 {
            font-size: 3rem;
            font-weight: 800;
        }
        .welcome-hero h1 span { color: #E8640A; }

        /* Cards de Imagens dos Animais */
        .pet-card {
            background: #151515;
            border: 1px solid #252525;
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .pet-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 20px rgba(232, 100, 10, 0.2);
        }
        .pet-img {
            width: 100%;
            height: 250px;
            object-fit: cover; /* Faz a foto se ajustar perfeitamente sem achatar */
        }
        .pet-info {
            padding: 15px;
            text-align: center;
        }

        /* Botão Principal de Entrada */
        .btn-enter {
            background: #E8640A;
            color: white;
            font-weight: 600;
            padding: 12px 35px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 1.1rem;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(232, 100, 10, 0.4);
        }
        .btn-enter:hover {
            background: #f97316;
            color: white;
            transform: scale(1.05);
        }
        
        .btn-logout-home {
            color: #dc3545;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-logout-home:hover { color: #ff4d5e; }
    </style>
</head>
<body>

    <nav class="home-nav d-flex justify-content-between align-items-center">
        <a href="#" class="logo-brand">🐾 Pet<span>Match</span></a>
        <div class="d-flex align-items-center gap-4">
            <span><i class="fa-solid fa-user-circle"></i> <?php echo $nome_exibicao; ?></span>
            <a href="logout.php" class="btn-logout-home"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </nav>

    <div class="container flex-grow-1 d-flex flex-column justify-content-center">
        
        <div class="welcome-hero">
            <h1>Olá, <span><?php echo $_SESSION['usuario']; ?></span>!</h1>
            <p class="text-secondary fs-5">Seja bem-vinda ao painel de gerenciamento de adoções e acolhimento.</p>
            
            <div class="mt-4">
                <a href="dashboard.php" class="btn-enter">
                    Acessar o Painel de Controle <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="row justify-content-center mb-5">
            
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="pet-card">
                    <img src="assets/img/pet1.jpg" onerror="this.src='https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=500'" class="pet-img" alt="Pet">
                    <div class="pet-info">
                        <h6 class="m-0 text-white-50"><i class="fa-solid fa-heart text-danger"></i> Resgatados</h6>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="pet-card">
                    <img src="assets/img/pet2.jpg" onerror="this.src='https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=500'" class="pet-img" alt="Pet">
                    <div class="pet-info">
                        <h6 class="m-0 text-white-50"><i class="fa-solid fa-paw text-warning"></i> Prontos para Adoção</h6>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="pet-card">
                    <img src="assets/img/pet3.jpg" onerror="this.src='https://images.unsplash.com/photo-1444212477490-ca407925329e?w=500'" class="pet-img" alt="Pet">
                    <div class="pet-info">
                        <h6 class="m-0 text-white-50"><i class="fa-solid fa-house-chimney text-success"></i> Lar Temporário</h6>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <footer class="text-center py-3 text-secondary small style="background: #111; border-top: 1px solid #222;"">
        &copy; <?php echo date('Y'); ?> PetMatch - Todos os direitos reservados.
    </footer>

</body>
</html>