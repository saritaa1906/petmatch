<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../login.php"); exit(); }
include '../config/conexao.php';

$id = $_GET['id'];
$sql = "SELECT p.*, an.nome AS animal_nome, an.especie_id, ad.nome AS adotante_nome, ad.cpf, ad.telefone, v.nome AS voluntario_nome 
        FROM processos_adocao p
        INNER JOIN animais an ON p.animal_id = an.id
        INNER JOIN adotantes ad ON p.adotante_id = ad.id
        INNER JOIN voluntarios v ON p.voluntario_id = v.id
        WHERE p.id = $id";
$proc = mysqli_fetch_assoc(mysqli_query($conn, $sql));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Processo - PetMatch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0D0D0D; color: white; }
        .container-custom { max-width: 800px; margin: 40px auto; }
        .card-detalhes { background: #151515; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); border: 1px solid #333; }
        .info-group { margin-bottom: 20px; border-bottom: 1px solid #222; padding-bottom: 10px; }
        .info-label { color: #8B5CF6; font-weight: bold; text-transform: uppercase; font-size: 0.85rem; }
        .info-data { font-size: 1.1rem; color: #eee; }
        .btn-pdf { background: #0A3D91; color: white; font-weight: bold; padding: 12px; border-radius: 8px; text-decoration: none; display: block; text-align: center; border: 1px solid #4A90E2; transition: 0.3s; }
        .btn-pdf:hover { background: #4A90E2; color: white;}
        .btn-voltar { background: #222; color: white; border: 1px solid #444; border-radius: 8px; padding: 10px; text-decoration: none; width: 100%; display: block; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
<div class="container container-custom">
    <h2 class="text-center mb-4" style="color:#8B5CF6;">Detalhes do Processo #<?php echo str_pad($proc['id'], 4, '0', STR_PAD_LEFT); ?></h2>
    
    <div class="card-detalhes">
        <div class="row">
            <div class="col-md-6 info-group">
                <div class="info-label">🐾 Animal</div>
                <div class="info-data"><?php echo $proc['animal_nome']; ?></div>
            </div>
            <div class="col-md-6 info-group">
                <div class="info-label">👤 Adotante</div>
                <div class="info-data"><?php echo $proc['adotante_nome']; ?> (Tel: <?php echo $proc['telefone']; ?>)</div>
            </div>
            <div class="col-md-6 info-group">
                <div class="info-label">🤝 Voluntário Responsável</div>
                <div class="info-data"><?php echo $proc['voluntario_nome']; ?></div>
            </div>
            <div class="col-md-6 info-group">
                <div class="info-label">📊 Status Atual</div>
                <div class="info-data text-warning"><?php echo $proc['status']; ?></div>
            </div>
            <div class="col-md-6 info-group">
                <div class="info-label">📅 Data de Abertura</div>
                <div class="info-data"><?php echo date("d/m/Y", strtotime($proc['data_abertura'])); ?></div>
            </div>
            <div class="col-md-6 info-group">
                <div class="info-label">🏁 Data de Conclusão</div>
                <div class="info-data"><?php echo $proc['data_conclusao'] ? date("d/m/Y", strtotime($proc['data_conclusao'])) : 'Em andamento...'; ?></div>
            </div>
            <div class="col-md-12 info-group border-0">
                <div class="info-label">📝 Observações</div>
                <div class="info-data"><?php echo $proc['observacoes'] ? $proc['observacoes'] : 'Nenhuma observação registrada.'; ?></div>
            </div>
        </div>

        <div class="mt-4">
            <a href="../pdf/termo_adocao.php?id=<?php echo $proc['id']; ?>" class="btn-pdf" target="_blank">📄 Emitir Termo de Responsabilidade (PDF)</a>
            <a href="listar.php" class="btn-voltar">Voltar para a Lista</a>
        </div>
    </div>
</div>
</body>
</html>