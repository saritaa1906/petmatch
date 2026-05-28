<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../login.php"); exit(); }
include '../config/conexao.php';

$animais = mysqli_query($conn, "SELECT id, nome FROM animais");
$adotantes = mysqli_query($conn, "SELECT id, nome FROM adotantes");
$voluntarios = mysqli_query($conn, "SELECT id, nome FROM voluntarios");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $animal_id = $_POST['animal_id']; $adotante_id = $_POST['adotante_id']; $voluntario_id = $_POST['voluntario_id'];
    $data_abertura = $_POST['data_abertura']; $observacoes = $_POST['observacoes'];

    $sql = "INSERT INTO processos_adocao (animal_id, adotante_id, voluntario_id, status, data_abertura, observacoes) 
            VALUES ('$animal_id', '$adotante_id', '$voluntario_id', 'Pendente', '$data_abertura', '$observacoes')";
    mysqli_query($conn, $sql);
    header("Location: listar.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Processo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0D0D0D; color: white; }
        .form-wrapper { max-width: 800px; margin: 50px auto; background: #151515; padding: 30px; border-radius: 15px; border-top: 4px solid #8B5CF6; }
        .form-control, .form-select { background: #1a1a1a; border: 1px solid #333; color: white;}
        .btn-salvar { background: #8B5CF6; color: white; width: 100%; padding: 10px; border-radius: 8px; border:none; margin-top: 15px;}
    </style>
</head>
<body>
<div class="container form-wrapper">
    <h3 style="color:#8B5CF6; text-align:center; margin-bottom:20px;">Abrir Processo de Adoção</h3>
    <form method="POST">
        <div class="row">
            <div class="col-md-4 mb-3"><label>Animal</label><select name="animal_id" class="form-select" required><option value="">Selecione...</option><?php while($r=mysqli_fetch_assoc($animais)) echo "<option value='{$r['id']}'>{$r['nome']}</option>"; ?></select></div>
            <div class="col-md-4 mb-3"><label>Adotante</label><select name="adotante_id" class="form-select" required><option value="">Selecione...</option><?php while($r=mysqli_fetch_assoc($adotantes)) echo "<option value='{$r['id']}'>{$r['nome']}</option>"; ?></select></div>
            <div class="col-md-4 mb-3"><label>Voluntário</label><select name="voluntario_id" class="form-select" required><option value="">Selecione...</option><?php while($r=mysqli_fetch_assoc($voluntarios)) echo "<option value='{$r['id']}'>{$r['nome']}</option>"; ?></select></div>
        </div>
        <div class="mb-3"><label>Data de Abertura</label><input type="date" name="data_abertura" class="form-control" value="<?php echo date('Y-m-d'); ?>" required></div>
        <div class="mb-3"><label>Observações</label><textarea name="observacoes" class="form-control"></textarea></div>
        <button type="submit" class="btn-salvar">Salvar</button>
        <a href="listar.php" class="btn btn-dark w-100 mt-2">Cancelar</a>
    </form>
</div>
</body>
</html>