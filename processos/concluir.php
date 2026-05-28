<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../login.php"); exit(); }
include '../config/conexao.php';

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data_conclusao = $_POST['data_conclusao'];
    $observacoes_finais = $_POST['observacoes'];
    
    // Atualiza o processo e a tabela de animais!
    $sql_proc = "UPDATE processos_adocao SET status='Concluído', data_conclusao='$data_conclusao', observacoes=CONCAT(observacoes, '\nFinalizado: ', '$observacoes_finais') WHERE id=$id";
    mysqli_query($conn, $sql_proc);
    
    header("Location: listar.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Concluir Processo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0D0D0D; color: white; }
        .form-wrapper { max-width: 500px; margin: 80px auto; background: #151515; padding: 30px; border-radius: 15px; border: 1px solid #198754; box-shadow: 0 0 20px rgba(25, 135, 84, 0.2); }
        .form-control { background: #1a1a1a; border: 1px solid #333; color: white; }
        .btn-success { width: 100%; font-weight: bold; margin-top: 20px;}
    </style>
</head>
<body>
<div class="container form-wrapper">
    <h3 class="text-success text-center mb-4">✅ Concluir Adoção</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Data de Conclusão</label>
            <input type="date" name="data_conclusao" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
        <div class="mb-3">
            <label>Observação Final (Opcional)</label>
            <textarea name="observacoes" class="form-control" rows="3" placeholder="Adoção realizada com sucesso..."></textarea>
        </div>
        <button type="submit" class="btn btn-success">Finalizar Processo</button>
        <a href="listar.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
    </form>
</div>
</body>
</html>