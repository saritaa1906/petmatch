<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../login.php"); exit(); }
include '../config/conexao.php';

$mensagem = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cpf = mysqli_real_escape_string($conn, $_POST['cpf']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
    $area_atuacao = mysqli_real_escape_string($conn, $_POST['area_atuacao']);
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $senha = $_POST['senha'];
    
    // Criptografia BCrypt para a senha do sistema
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
    
    // Verifica se o usuário já existe
    $check = mysqli_query($conn, "SELECT id FROM voluntarios WHERE usuario = '$usuario'");
    if(mysqli_num_rows($check) > 0) {
        $mensagem = "<div class='alert alert-danger'>Este nome de usuário já está em uso!</div>";
    } else {
        // Query adaptada para salvar toda a estrutura da sua tabela
        $sql = "INSERT INTO voluntarios (nome, cpf, email, telefone, area_atuacao, usuario, senha, ativo) 
                VALUES ('$nome', '$cpf', '$email', '$telefone', '$area_atuacao', '$usuario', '$senha_hash', TRUE)";
                
        if(mysqli_query($conn, $sql)) {
            header("Location: listar.php");
            exit();
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao cadastrar: " . mysqli_error($conn) . "</div>";
        }
    }
}

$titulo_pagina = "Cadastrar Voluntário - PetMatch";
$cor_modulo    = "#DC3545";
include '../includes/header.php';
include '../includes/menu.php';
?>

<style>
    .container-custom { max-width: 700px; margin: 40px auto; }
    .form-wrapper { background: #151515; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(220, 53, 69, 0.1); border: 1px solid #222; }
    .form-title { color: #DC3545; font-weight: 600; font-size: 1.1rem; margin-bottom: 20px; border-bottom: 1px solid #222; padding-bottom: 10px; }
    .input-custom { background: #1a1a1a !important; border: 1px solid #333 !important; color: #fff !important; border-radius: 8px; padding: 10px; }
    .input-custom:focus { border-color: #DC3545 !important; box-shadow: 0 0 8px rgba(220, 53, 69, 0.3) !important; }
    .btn-salvar { background: #DC3545; color: white; border: none; border-radius: 8px; padding: 12px; font-weight: bold; width: 100%; transition: 0.3s; margin-top: 15px; }
    .btn-salvar:hover { background: #bb2d3b; box-shadow: 0 0 15px rgba(220, 53, 69, 0.4); }
    .btn-cancelar { background: #222; color: #fff; border: 1px solid #444; border-radius: 8px; padding: 6px 16px; text-decoration: none; }
    .btn-cancelar:hover { background: #333; color: white; }
</style>

<div class="container container-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="m-0 text-white font-weight-bold">➕ Adicionar Voluntário</h3>
        <a href="listar.php" class="btn-cancelar">Voltar</a>
    </div>

    <div class="form-wrapper">
        <?php echo $mensagem; ?>
        
        <form action="" method="POST">
            <div class="form-title">📋 Informações Pessoais e Profissionais</div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-secondary mb-2 small">Nome Completo</label>
                    <input type="text" name="nome" class="form-control input-custom" placeholder="Ex: Camila Souza" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-secondary mb-2 small">CPF</label>
                    <input type="text" name="cpf" class="form-control input-custom" placeholder="000.000.000-00" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-secondary mb-2 small">E-mail</label>
                    <input type="email" name="email" class="form-control input-custom" placeholder="nome@email.com" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-secondary mb-2 small">Telefone</label>
                    <input type="text" name="telefone" class="form-control input-custom" placeholder="(00) 00000-0000" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="text-secondary mb-2 small">Área de Atuação</label>
                <input type="text" name="area_atuacao" class="form-control input-custom" placeholder="Ex: Veterinária, Administrativo, Resgate" required>
            </div>

            <div class="form-title">🔑 Credenciais de Acesso ao Sistema</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-secondary mb-2 small">Usuário (Login)</label>
                    <input type="text" name="usuario" class="form-control input-custom" placeholder="Ex: camila.souza" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-secondary mb-2 small">Senha</label>
                    <input type="password" name="senha" class="form-control input-custom" placeholder="Defina uma senha" required>
                </div>
            </div>
            
            <button type="submit" class="btn-salvar">💾 Cadastrar Novo Voluntário</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>