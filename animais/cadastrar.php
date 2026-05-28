<?php
session_start();

// Proteção: Se não estiver logado, redireciona para o login
if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

include '../config/conexao.php'; // Caminho voltando uma pasta até a config

// Processamento do Formulário ao clicar em Salvar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $especie_id = intval($_POST['especie_id']);
    $raca_id = intval($_POST['raca_id']);
    $idade = !empty($_POST['idade']) ? intval($_POST['idade']) : 'NULL';
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Insere o animal associando a espécie e a raça corretas
    $sql = "INSERT INTO animais (nome, especie_id, raca_id, idade, status) VALUES ('$nome', $especie_id, $raca_id, $idade, '$status')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Animal cadastrado com sucesso!'); window.location.href='listar.php';</script>";
        exit();
    } else {
        $erro = "Erro ao cadastrar: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Animal - PetMatch</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #0D0D0D;
            background-image: url('../assets/img/bg-paws.png'); 
            background-repeat: repeat;
            color: white;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card-cadastro {
            background: linear-gradient(145deg, #151515, #1c1c1c);
            border: 1px solid #252525;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 500px;
        }
        .form-control, .form-select {
            background-color: #222 !important;
            border: 1px solid #333 !important;
            color: white !important;
            border-radius: 10px;
            padding: 10px 12px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #E8640A !important;
            box-shadow: 0 0 8px rgba(232, 100, 10, 0.4) !important;
        }
        .btn-salvar {
            background: #E8640A;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            border: none;
            transition: 0.3s;
        }
        .btn-salvar:hover {
            background: #f97316;
            color: white;
        }
        .btn-voltar {
            color: #aaa;
            text-decoration: none;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .btn-voltar:hover {
            color: white;
        }
        label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #ccc;
        }
    </style>
</head>
<body>

<div class="card-cadastro">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="m-0 fw-bold text-white"><i class="fa-solid fa-paw text-warning"></i> Novo Pet</h3>
        <a href="listar.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
    </div>

    <?php if(isset($erro)): ?>
        <div class="alert alert-danger" style="background: #2c1a1d; border-color: #5c242a; color: #ff8591;">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <form action="cadastrar.php" method="POST">
        
        <div class="mb-3">
            <label for="nome">Nome do Pet</label>
            <input type="text" name="nome" id="nome" class="form-control" placeholder="Ex: Paçoca" required>
        </div>

        <div class="mb-3">
            <label for="select-especie">Espécie</label>
            <select name="especie_id" id="select-especie" class="form-select" required>
                <option value="">Selecione uma espécie...</option>
                <?php
                // Puxa as espécies cadastradas do seu SQL
                $query_esp = mysqli_query($conn, "SELECT * FROM especies ORDER BY nome ASC");
                while ($esp = mysqli_fetch_assoc($query_esp)) {
                    echo "<option value='{$esp['id']}'>{$esp['nome']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="select-raca">Raça</label>
            <select name="raca_id" id="select-raca" class="form-select" disabled required>
                <option value="">Selecione uma espécie primeiro...</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="idade">Idade aproximada (Anos)</label>
            <input type="number" name="idade" id="idade" class="form-control" placeholder="Deixe vazio se não souber" min="0">
        </div>

        <div class="mb-4">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="Disponível">Disponível para Adoção</option>
                <option value="Lar Temporário">Em Lar Temporário</option>
                <option value="Adotado">Adotado 🎉</option>
            </select>
        </div>

        <button type="submit" class="btn-salvar">
            <i class="fa-solid fa-save"></i> Salvar Cadastro
        </button>

    </form>
</div>

<script src="../assets/js/script.js"></script>

</body>
</html>