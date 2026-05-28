<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../voluntarios/login.php"); exit(); }
include '../config/conexao.php';

$id = intval($_GET['id']);
$mensagem = "";

// Carrega os dados atuais
$busca = mysqli_query($conn, "SELECT * FROM voluntarios WHERE id = $id");
$vol = mysqli_fetch_assoc($busca);

if(!$vol) { header("Location: listar.php"); exit(); }

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $senha = $_POST['senha'];
    
    // Atualiza com ou sem senha nova
    if(!empty($senha)) {
        $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
        $sql = "UPDATE voluntarios SET nome='$nome', usuario='$usuario', senha='$senha_hash' WHERE id=$id";
    } else {
        $sql = "UPDATE voluntarios SET nome='$nome', usuario='$usuario' WHERE id=$id";
    }
    
    if(mysqli_query($conn, $sql)) {
        // Se alterou as próprias credenciais, atualiza a sessão
        if($id == $_SESSION['id_usuario_logado'] ?? 0) {
            $_SESSION['usuario'] = $usuario;
        }
        header("Location: listar.php");
        exit();
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao atualizar: " . mysqli_error($conn) . "</div>";
    }
}

$titulo_pagina = "Editar Voluntário - PetMatch";
$cor_modulo    = "#DC3545";
include '../includes/header.php';
include '../includes/menu.php';
?>

<style>
    .container-custom { max-width: 600px; margin: 50px auto; }
    .form-wrapper { background: #151515; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(220, 53, 69, 0.1); border: 1px solid #222; }
    .form-title { color: #DC3545; font-weight: 600; font-size: 1.2rem; margin-bottom: 25px; }
    .input-custom { background: #1a1a1a !important; border: 1px solid #333 !important; color: #fff !important; border-radius: 8px; padding: 11px; }
    .input-custom:focus { border-color: #DC3545 !important; box-shadow: 0 0 8px rgba(220, 53, 69, 0.3) !important; }
    .btn-salvar { background: #DC3545; color: white; border: none; border-radius: 8px; padding: 12px; font-weight: bold; width: 100%; transition: 0.3s; }
    .btn-salvar:hover { background: #bb2d3b; box-shadow: 0 0 15px rgba(220, 53, 69, 0.4); }
    .btn-cancelar { background: #222; color: #fff; border: 1px solid #444; border-radius: 8px; padding: 6px 16px; text-decoration: none; }
    .btn-cancelar:hover { background: #333; color: white; }
</style>

<div class="container container-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="m-0 text-white font-weight-bold">✏️ Modificar Voluntário</h3>
        <a href="listar.php" class="btn-cancelar">Cancelar</a>
    </div>

    <div class="form-wrapper">
        <div class="form-title">Atualizar Registro #<?php echo str_pad($vol['id'], 3, '0', STR_PAD_LEFT); ?></div>
        <?php echo $mensagem; ?>
        
        <form action="" method="POST">
            <div class="mb-3">
                <label class="text-secondary mb-2 small">Nome Completo</label>
                <input type="text" name="nome" class="form-control input-custom" value="<?php echo htmlspecialchars($vol['nome']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="text-secondary mb-2 small">Usuário de Acesso</label>
                <input type="text" name="usuario" class="form-control input-custom" value="<?php echo htmlspecialchars($vol['usuario']); ?>" required>
            </div>
            <div class="mb-4">
                <label class="text-secondary mb-2 small">Nova Senha (Deixe em branco para não alterar)</label>
                <input type="password" name="senha" class="form-control input-custom" placeholder="Sua senha atual continuará ativa">
            </div>
            
            <button type="submit" class="btn-salvar">🔄 Atualizar Informações</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>