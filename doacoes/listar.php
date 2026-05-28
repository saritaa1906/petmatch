<?php
session_start();
if(!isset($_SESSION['usuario'])) { 
    header("Location: ../voluntarios/login.php"); 
    exit(); 
}

require_once '../config/conexao.php';

// VARIÁVEIS DE CONFIGURAÇÃO DO INCLUDES (Tema Verde para Doações)
$titulo_pagina = "Doações - PetMatch";
$cor_modulo    = "#10B981"; // Verde Esmeralda

include '../includes/header.php';
include '../includes/menu.php';

// Busca as doações trazendo o nome do adotante correspondente
$sql = "SELECT 
            d.id, d.valor, d.data_doacao, d.tipo, d.descricao,
            ad.nome AS adotante_nome
        FROM doacoes d
        INNER JOIN adotantes ad ON d.adotante_id = ad.id
        ORDER BY d.id DESC";
$resultado = mysqli_query($conn, $sql);
?>

<style>
    .container-custom { max-width: 1200px; margin: 40px auto; }
    .page-header { border-bottom: 2px solid #10B981; padding-bottom: 15px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
    .page-header h2 { margin: 0; font-weight: bold; color: #f8f9fa; }
    .page-header h2 span { color: #10B981; }
    
    .table-wrapper { background: #151515; border-radius: 15px; padding: 20px; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.12); border: 1px solid #222; }
    
    /* Configurações Dark Mode para a tabela */
    .table-custom { --bs-table-bg: transparent; margin-bottom: 0; }
    .table-custom th { color: #10B981 !important; border-bottom: 2px solid #333 !important; font-weight: 600; text-transform: uppercase; font-size: 0.9rem; background: transparent !important; }
    .table-custom td { color: #ccc !important; border-bottom: 1px solid #222 !important; vertical-align: middle; background: transparent !important; }
    
    /* Efeito hover nas linhas da tabela */
    .table-custom tbody tr { transition: all 0.3s ease; }
    .table-custom tbody tr:hover { background-color: rgba(16, 185, 129, 0.12) !important; }
    .table-custom tbody tr:hover td { color: #fff !important; }
    
    /* Botões do topo */
    .btn-novo { background: #10B981; color: #000; border-radius: 8px; padding: 8px 20px; font-weight: bold; text-decoration: none; transition: 0.3s; border: none; }
    .btn-novo:hover { background: #059669; color: white; box-shadow: 0 0 12px rgba(16, 185, 129, 0.4); }
    .btn-voltar { background: #222; color: white; border: 1px solid #444; border-radius: 8px; padding: 8px 20px; text-decoration: none; transition: 0.3s; margin-left: 10px; }
    .btn-voltar:hover { background: #333; color: white; }
    .btn-relatorio { background: #0A3D91; color: white; border-radius: 8px; padding: 8px 20px; font-weight: bold; text-decoration: none; transition: 0.3s; }
    .btn-relatorio:hover { background: #082d6b; color: white; }
    
    /* Botões de Ação na tabela */
    .btn-acao { text-decoration: none; padding: 5px 10px; border-radius: 6px; font-size: 0.85rem; margin-right: 4px; transition: 0.3s; display: inline-block; margin-bottom: 2px; }
    .btn-editar { background: #222; color: #ffc107; border: 1px solid #ffc107; }
    .btn-editar:hover { background: #ffc107; color: #000; }
    .btn-excluir { background: #222; color: #dc3545; border: 1px solid #dc3545; }
    .btn-excluir:hover { background: #dc3545; color: #fff; }
</style>

<div class="container container-custom">
    <div class="page-header">
        <h2>💰 Gestão de <span>Doações</span></h2>
        <div>
            <a href="relatorio.php" class="btn-relatorio">📊 Filtro de Relatório</a>
            <a href="cadastrar.php" class="btn-novo">+ Nova Doação</a>
            <a href="../dashboard.php" class="btn-voltar">⬅ Voltar</a>
        </div>
    </div>
    
    <div class="table-wrapper table-responsive">
        <table class="table table-custom table-borderless align-middle">
            <thead>
                <tr>
                    <th style="width: 100px;">ID</th>
                    <th>Doador (Adotante)</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Forma</th>
                    <th>Descrição</th>
                    <th class="text-center" style="width: 120px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(mysqli_num_rows($resultado) > 0){
                    while($doacao = mysqli_fetch_assoc($resultado)){
                        
                        $valor_formatado = "R$ " . number_format($doacao['valor'], 2, ',', '.');
                        
                        echo "<tr>";
                        echo "<td><strong>#". str_pad($doacao['id'], 4, '0', STR_PAD_LEFT) ."</strong></td>";
                        echo "<td>{$doacao['adotante_nome']}</td>";
                        echo "<td style='color: #10B981 !important; font-weight: bold;'>{$valor_formatado}</td>";
                        echo "<td>".date("d/m/Y", strtotime($doacao['data_doacao']))."</td>";
                        echo "<td><span class='badge bg-dark border border-secondary text-light px-2.5 py-1.5'>{$doacao['tipo']}</span></td>";
                        echo "<td style='max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>{$doacao['descricao']}</td>";
                        
                        echo "<td class='text-center'>";
                        echo "<a href='editar.php?id={$doacao['id']}' class='btn-acao btn-editar' title='Editar'>✏️</a>";
                        echo "<a href='excluir.php?id={$doacao['id']}' class='btn-acao btn-excluir' title='Excluir' onclick=\"return confirm('Deseja realmente excluir este registro de doação?');\">🗑️</a>";
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center py-4' style='color: #666 !important;'>Nenhuma doação registrada até o momento.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
include '../includes/footer.php'; 
?>