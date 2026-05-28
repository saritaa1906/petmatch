<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

include 'config/conexao.php';

// Busca os totais tratando possíveis erros de tabela inexistente
$res_animais = mysqli_query($conn, "SELECT * FROM animais");
$animais = $res_animais ? mysqli_num_rows($res_animais) : 0;

$res_adotantes = mysqli_query($conn, "SELECT * FROM adotantes");
$adotantes = $res_adotantes ? mysqli_num_rows($res_adotantes) : 0;

$res_doacoes = mysqli_query($conn, "SELECT * FROM doacoes");
$doacoes = $res_doacoes ? mysqli_num_rows($res_doacoes) : 0;

$res_voluntarios = mysqli_query($conn, "SELECT * FROM voluntarios");
$voluntarios = $res_voluntarios ? mysqli_num_rows($res_voluntarios) : 0;

$res_processos = mysqli_query($conn, "SELECT * FROM processos");
$processos = $res_processos ? mysqli_num_rows($res_processos) : 0;

$nome_exibicao = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PetMatch</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #0D0D0D;
            /* SEU ASSETS: Imagem de fundo sutil de patinhas */
            background-image: url('assets/img/bg-paws.png'); 
            background-repeat: repeat;
            color: white;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }
        
        /* Sidebar Lateral Fixa */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #111;
            position: fixed;
            padding: 25px 20px;
            border-right: 1px solid #222;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar-brand {
            font-weight: bold;
            color: #fff;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 25px;
        }
        .sidebar-brand span { color: #E8640A; }
        
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #aaa;
            text-decoration: none;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 12px;
            font-weight: 500;
            transition: 0.3s;
        }
        
        .sidebar a i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(232, 100, 10, 0.15);
            color: #E8640A;
        }

        /* Botão Sair Vermelho na Base da Sidebar */
        .sidebar a.btn-logout-sidebar {
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
            margin-top: auto;
        }
        .sidebar a.btn-logout-sidebar:hover {
            background: #dc3545;
            color: white;
            box-shadow: 0 0 15px rgba(220, 53, 69, 0.4);
        }

        /* Área do Conteúdo Principal */
        .content {
            margin-left: 280px;
            padding: 40px;
        }

        /* Cards Estilizados */
        .card-dashboard {
            background: linear-gradient(145deg, #151515, #1c1c1c);
            border: 1px solid #252525;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            transition: transform 0.3s;
            position: relative;
            overflow: hidden;
        }
        .card-dashboard:hover { transform: translateY(-5px); }
        .card-dashboard h5 { color: #888; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }
        .card-dashboard h1 { font-size: 2.8rem; font-weight: bold; margin-top: 10px; margin-bottom: 0; }
        
        /* Ícones Grandes em marca d'água dentro dos cards */
        .card-icon { position: absolute; right: 20px; bottom: 15px; font-size: 3.5rem; opacity: 0.12; color: #fff; }
        .card-animais { border-left: 4px solid #E8640A; }
        .card-adotantes { border-left: 4px solid #007bff; }
        .card-doacoes { border-left: 4px solid #28a745; }

        /* Container do Gráfico */
        .chart-wrapper {
            background: #151515;
            border: 1px solid #222;
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div>
        <div class="sidebar-brand">
            🐾 Pet<span>Match</span>
        </div>
        <hr style="border-color: #333;">

        <a href="dashboard.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
        
        <a href="animais/listar.php"><i class="fa-solid fa-paw"></i> Animais</a>
        
        <a href="adotantes/listar.php"><i class="bi bi-people-fill"></i> Adotantes</a>
        <a href="voluntarios/listar.php"><i class="bi bi-heart-fill"></i> Voluntários</a>
        <a href="processos/listar.php"><i class="bi bi-file-earmark-text-fill"></i> Processos</a>
        <a href="doacoes/listar.php"><i class="bi bi-cash-coin"></i> Doações</a>
    </div>

    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/petmatch/logout.php" class="btn-logout-sidebar">
        <i class="bi bi-box-arrow-left"></i> Sair do Sistema
    </a>
</div>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0">Painel de Controle</h2>
            <p class="text-secondary m-0">Bem-vinda de volta, <strong class="text-white"><?php echo $nome_exibicao; ?></strong> 💙</p>
        </div>
        <img src="assets/img/avatar.png" class="rounded-circle" width="60" height="60">
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card-dashboard card-animais">
                <h5>🐶 Animais Cadastrados</h5>
                <h1><?php echo $animais; ?></h1>
                <i class="fa-solid fa-paw card-icon"></i>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card-dashboard card-adotantes">
                <h5>👤 Adotantes Registrados</h5>
                <h1><?php echo $adotantes; ?></h1>
                <i class="bi bi-people-fill card-icon"></i>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card-dashboard card-doacoes">
                <h5>💰 Registro de Doações</h5>
                <h1><?php echo $doacoes; ?></h1>
                <i class="bi bi-cash-coin card-icon"></i>
            </div>
        </div>
    </div>

    <div class="chart-wrapper">
        <h5 class="text-secondary mb-4 small text-uppercase tracking-wider">📊 Visão Geral do Ecossistema PetMatch</h5>
        <div class="row align-items-center">
            <div class="col-md-6 text-secondary">
                <p>O gráfico ao lado ilustra a proporção e o volume atual de dados gerenciados em tempo real dentro do seu sistema.</p>
                <ul>
                    <li class="mb-2">Processos de Adoção: <strong class="text-white"><?php echo $processos; ?></strong></li>
                    <li>Voluntários Integrados: <strong class="text-white"><?php echo $voluntarios; ?></strong></li>
                </ul>
            </div>
            <div class="col-md-6" style="max-height: 280px; display: flex; justify-content: center;">
                <canvas id="graficoPetMatch"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="assets/js/script.js"></script>

<script>
    // Inicializa a função do gráfico que está salva na sua pasta assets/js/
    inicializarGrafico({
        animais: <?php echo $animais; ?>,
        adotantes: <?php echo $adotantes; ?>,
        doacoes: <?php echo $doacoes; ?>,
        voluntarios: <?php echo $voluntarios; ?>,
        processos: <?php echo $processos; ?>
    });
</script>

</body>
</html>