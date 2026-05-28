<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../login.php"); exit(); }
include '../config/conexao.php';
$id = $_GET['id'];
$proc = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM processos_adocao WHERE id = $id"));

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $status = $_POST['status']; $observacoes = $_POST['observacoes'];
    mysqli_query($conn, "UPDATE processos_adocao SET status='$status', observacoes='$observacoes' WHERE id=$id");
    header("Location: listar.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Processo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: #0D0D0D; color: white; } .form-wrapper { max-width: 600px; margin: 50px auto; background: #151515; padding: 30px; border-radius: 15px; border-top: 4px solid #ffc107; } .form-control, .form-select { background: #1a1a1a; border: 1px solid #333; color: white;} </style>
</head>
<body>
<div class="container form-wrapper">
    <h3 class="text-warning text-center">Editar Processo #<?php echo $id; ?></h3>
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="Pendente" <?php if($proc['status']=='Pendente') echo 'selected';?>>Pendente</option>
                <option value="Aprovado" <?php if($proc['status']=='Aprovado') echo 'selected';?>>Aprovado</option>
                <option value="Reprovado" <?php if($proc['status']=='Reprovado') echo 'selected';?>>Reprovado</option>
            </select>
        </div>
        <div class="mb-3"><label>Observações</label><textarea name="observacoes" class="form-control" rows="4"><?php echo $proc['observacoes']; ?></textarea></div>
        <button type="submit" class="btn btn-warning w-100">Atualizar</button>
        <a href="listar.php" class="btn btn-dark w-100 mt-2">Cancelar</a>
    </form>
</div>
</body>
</html>