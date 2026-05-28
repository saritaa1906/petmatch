<?php
// Garante que a sessão está ativa para puxar o nome do usuário logado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define o nome de exibição do usuário (padrão 'Administrador' caso não encontre na sessão)
$nome_exibicao = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : 'Administrador';
?>

<style>
    /* Estilização da Navbar Superior para manter o padrão Dark elegante */
    .navbar-petmatch {
        background-color: #111111 !important;
        border-bottom: 1px solid #222;
        padding: 12px 25px;
    }
    .navbar-brand-pet {
        font-weight: bold;
        color: #fff !important;
        font-size: 1.4rem;
        text-decoration: none;
    }
    .navbar-brand-pet span {
        color: #E8640A; /* Laranja padrão do PetMatch */
    }
    .nav-link-pet {
        color: #aaa !important;
        font-weight: 500;
        margin-right: 20px;
        transition: 0.3s;
        text-decoration: none;
    }
    .nav-link-pet:hover {
        color: #E8640A !important;
    }
    /* Estilo customizado para o botão Sair Vermelho */
    .btn-sair-vermelho {
        color: #dc3545 !important;
        border: 1px solid #dc3545 !important;
        background: transparent;
        padding: 6px 16px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }
    .btn-sair-vermelho:hover {
        background: #dc3545 !important;
        color: white !important;
        box-shadow: 0 0 12px rgba(220, 53, 69, 0.4);
    }
</style>

<nav class="navbar navbar-expand-lg navbar-petmatch mb-4">
    <div class="container-fluid">
        <a class="navbar-brand-pet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/petmatch/dashboard.php">
            🐾 Pet<span>Match</span>
        </a>
        
        <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link-pet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/petmatch/animais/listar.php">🐶 Animais</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-pet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/petmatch/processos/listar.php">📄 Processos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-pet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/petmatch/adotantes/listar.php">👤 Adotantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-pet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/petmatch/doacoes/listar.php">💰 Doações</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-pet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/petmatch/voluntarios/listar.php">🤝 Voluntários</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <span class="text-secondary small">
                    👋 Olá, <strong class="text-white"><?php echo $nome_exibicao; ?></strong>
                </span>
                
                <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/petmatch/logout.php" class="btn-sair-vermelho">
                    Sair
                </a>
            </div>
        </div>
    </div>
</nav>