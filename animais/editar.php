<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../voluntarios/login.php");
    exit();
}

include '../config/conexao.php';

// VARIÁVEIS DE CONFIGURAÇÃO DO INCLUDES (Tema Laranja para Animais)
$titulo_pagina = "Editar Pet - PetMatch";
$cor_modulo    = "#E8640A"; 

include '../includes/header.php';
include '../includes/menu.php';

// Verifica se o ID do animal foi enviado na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID do animal inválido!'); window.location.href='listar.php';</script>";
    exit();
}

$id = intval($_GET['id']);

// Busca os dados atuais do animal para preencher o formulário
$query_animal = mysqli_query($conn, "SELECT * FROM animais WHERE id = $id");
$animal = mysqli_fetch_assoc($query_animal);

if (!$animal) {
    echo "<script>alert('Animal não encontrado!'); window.location.href='listar.php';</script>";
    exit();
}

// Processamento do Formulário ao clicar em Salvar Alterações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $especie_id = intval($_POST['especie_id']);
    $raca_id = intval($_POST['raca_id']);
    $idade = !empty($_POST['idade']) ? intval($_POST['idade']) : 'NULL';
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Query de atualização
    $sql_update = "UPDATE animais SET 
                    nome = '$nome', 
                    especie_id = $especie_id, 
                    raca_id = $raca_id, 
                    idade = $idade, 
                    status = '$status' 
                   WHERE id = $id";
    
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Alterações salvas com sucesso!'); window.location.href='listar.php';</script>";
        exit();
    } else {
        $erro = "Erro ao atualizar: " . mysqli_error($conn);
    }
}
?>

<style>
    .container-custom {
        max-width: 600px;
        margin: 50px auto;
    }
    .card-cadastro {
        background: linear-gradient(145deg, #151515, #1c1c1c);
        border: 1px solid #252525;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(232, 100, 10, 0.12);
        width: 100%;
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
        box-shadow: 0 0 12px rgba(232, 100, 10, 0.4);
    }
    .btn-voltar {
        color: #aaa;
        text-decoration: none;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #222;
        border: 1px solid #444;
        border-radius: 10px;
        padding: 10px 20px;
        width: 100%;
        justify-content: center;
    }
    .btn-voltar:hover {
        background: #444;
        color: white;
    }
    label {
        font-weight: 500;
        margin-bottom: 8px;
        color: #ccc;
    }
</style>

<div class="container container-custom">
    <div class="card-cadastro">
        <h3 class="mb-4 fw-bold text-white text-center">🐾 Editar Pet <span>#<?php echo str_pad($animal['id'], 3, '0', STR_PAD_LEFT); ?></span></h3>

        <?php if(isset($erro)): ?>
            <div class="alert alert-danger" style="background: #2c1a1d; border-color: #5c242a; color: #ff8591;">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form action="editar.php?id=<?php echo $id; ?>" method="POST">
            
            <div class="mb-3">
                <label for="nome">Nome do Pet</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?php echo htmlspecialchars($animal['nome']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="select-especie">Espécie</label>
                <select name="especie_id" id="select-especie" class="form-select" required>
                    <option value="">Selecione uma espécie...</option>
                    <?php
                    $query_esp = mysqli_query($conn, "SELECT * FROM especies ORDER BY nome ASC");
                    while ($esp = mysqli_fetch_assoc($query_esp)) {
                        $selected = ($esp['id'] == $animal['especie_id']) ? 'selected' : '';
                        echo "<option value='{$esp['id']}' $selected>{$esp['nome']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="select-raca">Raça</label>
                <select name="raca_id" id="select-raca" class="form-select" required>
                    <?php
                    // Já carrega as raças correspondentes à espécie atual do bicho para ele não vir em branco
                    $especie_atual = $animal['especie_id'];
                    $query_racas = mysqli_query($conn, "SELECT * FROM racas WHERE especie_id = $especie_atual ORDER BY nome ASC");
                    while ($raca = mysqli_fetch_assoc($query_racas)) {
                        $selected = ($raca['id'] == $animal['raca_id']) ? 'selected' : '';
                        echo "<option value='{$raca['id']}' $selected>{$raca['nome']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="idade">Idade aproximada (Anos)</label>
                <input type="number" name="idade" id="idade" class="form-control" value="<?php echo $animal['idade'] !== null ? $animal['idade'] : ''; ?>" placeholder="Deixe vazio se não souber" min="0">
            </div>

            <div class="mb-4">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="Disponível" <?php echo ($animal['status'] == 'Disponível') ? 'selected' : ''; ?>>Disponível para Adoção</option>
                    <option value="Lar Temporário" <?php echo ($animal['status'] == 'Lar Temporário') ? 'selected' : ''; ?>>Em Lar Temporário</option>
                    <option value="Adotado" <?php echo ($animal['status'] == 'Adotado') ? 'selected' : ''; ?>>Adotado 🎉</option>
                </select>
            </div>

            <div class="row g-2">
                <div class="col-md-8">
                    <button type="submit" class="btn-salvar">
                        <i class="fa-solid fa-save"></i> Salvar Alterações
                    </button>
                </div>
                <div class="col-md-4">
                    <a href="listar.php" class="btn-voltar">
                        Cancelar
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>

<script src="../assets/js/script.js"></script>

<?php 
include '../includes/footer.php'; 
?>