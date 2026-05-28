<?php
session_start();
if(!isset($_SESSION['usuario'])) { 
    header("Location: ../voluntarios/login.php"); 
    exit(); 
}

include '../config/conexao.php';

// VARIÁVEIS DE CONFIGURAÇÃO DO INCLUDES (Tema Roxo para Processos)
$titulo_pagina = "Processos - PetMatch";
$cor_modulo    = "#8B5CF6"; // Roxo Elétrico para Processos

include '../includes/header.php';
include '../includes/menu.php';

$sql = "SELECT 
            p.id, p.status, p.data_abertura,
            an.nome AS animal_nome,
            ad.nome AS adotante_nome,
            v.nome AS voluntario_nome
        FROM processos_adocao p
        INNER JOIN animais an ON p.animal_id = an.id
        INNER JOIN adotantes ad ON p.adotante_id = ad.id
        INNER JOIN voluntarios v ON p.voluntario_id = v.id
        ORDER BY p.id DESC";
$resultado = mysqli_query($conn, $sql);
?>

<style>
    .container-custom { max-width: 1200px; margin: 40px auto; }
    .page-header { border-bottom: 2px solid #8B5CF6; padding-bottom: 15px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
    .page-header h2 { margin: 0; font-weight: bold; color: #f8f9fa; }
    .page-header h2 span { color: #8B5CF6; }
    
    .table-wrapper { background: #151515; border-radius: 15px; padding: 20px; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); border: 1px solid #222; }
    
    /* Customização fina da tabela */
    .table-custom { --bs-table-bg: transparent; margin-bottom: 0; }
    .table-custom th { color: #8B5CF6 !important; border-bottom: 2px solid #333 !important; font-weight: 600; text-transform: uppercase; font-size: 0.9rem; background: transparent !important; }
    .table-custom td { color: #ccc !important; border-bottom: 1px solid #222 !important; vertical-align: middle; background: transparent !important; }
    
    /* Animação nas linhas da tabela */
    .table-custom tbody tr { transition: all 0.3s ease; }
    .table-custom tbody tr:hover { background-color: rgba(139, 92, 246, 0.12) !important; }
    .table-custom tbody tr:hover td { color: #fff !important; }
    
    /* Botões do topo */
    .btn-novo { background: #8B5CF6; color: white; border-radius: 8px; padding: 8px 20px; font-weight: bold; text-decoration: none; transition: 0.3s; border: none; }
    .btn-novo:hover { background: #7C3AED; color: white; box-shadow: 0 0 12px rgba(139, 92, 246, 0.4); }
    .btn-voltar { background: #222; color: white; border: 1px solid #444; border-radius: 8px; padding: 8px 20px; text-decoration: none; transition: 0.3s; margin-left: 10px; }
    .btn-voltar:hover { background: #333; color: white; }
    
    /* Botões de Ação internos */
    .btn-acao { text-decoration: none; padding: 5px 12px; border-radius: 6px; font-size: 0.85rem; margin-right: 4px; transition: 0.3s; display: inline-block; }
    .btn-detalhes { background: #222; color: #0dcaf0; border: 1px solid #0dcaf0; }
    .btn-detalhes:hover { background: #0dcaf0; color: #000; }
    .btn-concluir { background: #222; color: #198754; border: 1px solid #198754; }
    .btn-concluir:hover { background: #198754; color: #fff; }
    .btn-editar { background: #222; color: #ffc107; border: 1px solid #ffc107; padding: 5px 10px; }
    .btn-editar:hover { background: #ffc107; color: #000; }
    .btn-excluir { background: #222; color: #dc3545; border: 1px solid #dc3545; padding: 5px 10px; }
    .btn-excluir:hover { background: #dc3545; color: #fff; }
</style>

<div class="container container-custom">
    <div class="page-header">
        <h2>📄 Processos de <span>Adoção</span></h2>
        <div>
            <a href="cadastrar.php" class="btn-novo">+ Novo Processo</a>
            <a href="../dashboard.php" class="btn-voltar">⬅ Voltar</a>
        </div>
    </div>
    
    <div class="table-wrapper table-responsive">
        <table class="table table-custom table-borderless align-middle">
            <thead>
                <tr>
                    <th style="width: 90px;">ID</th>
                    <th>Animal</th>
                    <th>Adotante</th>
                    <th>Voluntário</th>
                    <th>Abertura</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 290px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(mysqli_num_rows($resultado) > 0){
                    while($proc = mysqli_fetch_assoc($resultado)){
                        $badge = 'bg-secondary';
                        if($proc['status'] == 'Pendente') $badge = 'bg-warning text-dark';
                        if($proc['status'] == 'Concluído' || $proc['status'] == 'Aprovado') $badge = 'bg-success';
                        
                        echo "<tr>";
                        echo "<td><strong>#". str_pad($proc['id'], 4, '0', STR_PAD_LEFT) ."</strong></td>";
                        echo "<td>{$proc['animal_nome']}</td>";
                        echo "<td>{$proc['adotante_nome']}</td>";
                        echo "<td>{$proc['voluntario_nome']}</td>";
                        echo "<td>".date("d/m/Y", strtotime($proc['data_abertura']))."</td>";
                        echo "<td><span class='badge {$badge} px-2.5 py-1.5'>{$proc['status']}</span></td>";
                        
                        echo "<td class='text-center'>";
                        echo "<a href='detalhes.php?id={$proc['id']}' class='btn-acao btn-detalhes' title='Ver Detalhes'>👁️ Detalhes</a>";
                        
                        if($proc['status'] != 'Concluído'){
                            echo "<a href='concluir.php?id={$proc['id']}' class='btn-acao btn-concluir' title='Concluir'>✅ Concluir</a>";
                        }
                        
                        echo "<a href='editar.php?id={$proc['id']}' class='btn-acao btn-editar' title='Editar'>✏️</a>";
                        echo "<a href='excluir.php?id={$proc['id']}' class='btn-acao btn-excluir' title='Excluir' onclick=\"return confirm('Deseja realmente excluir este processo?');\">🗑️</a>";
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center py-4' style='color: #666 !important;'>Nenhum processo encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
include '../includes/footer.php'; 
?>