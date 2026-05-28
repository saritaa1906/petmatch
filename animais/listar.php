<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../voluntarios/login.php");
    exit();
}

include '../config/conexao.php';

// VARIÁVEIS DE CONFIGURAÇÃO DO INCLUDES (Tema Laranja para Animais)
$titulo_pagina = "Animais - PetMatch";
$cor_modulo    = "#E8640A"; // Laranja da identidade dos Pets

include '../includes/header.php';
include '../includes/menu.php';

// SQL ATUALIZADO: Busca os dados trazendo os nomes reais das duas tabelas relacionadas
$sql = "SELECT 
            animais.id,
            animais.nome,
            animais.idade,
            animais.status,
            especies.nome AS especie,
            racas.nome AS raca
        FROM animais
        INNER JOIN especies ON animais.especie_id = especies.id
        INNER JOIN racas ON animais.raca_id = racas.id
        ORDER BY animais.id DESC";

$resultado = mysqli_query($conn, $sql);
?>

<style>
    .container-custom {
        max-width: 1100px;
        margin: 50px auto;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #E8640A;
        padding-bottom: 15px;
        margin-bottom: 30px;
    }
    .page-header h2 {
        margin: 0;
        font-weight: bold;
        color: #f8f9fa;
    }
    .page-header h2 span {
        color: #E8640A;
        text-shadow: 0 0 10px rgba(232, 100, 10, 0.3);
    }
    .botoes-topo {
        display: flex;
        gap: 10px;
    }
    .table-wrapper {
        background: #151515;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(232, 100, 10, 0.12);
    }
    .table-custom {
        color: white;
        margin-bottom: 0;
    }
    .table-custom th {
        background: transparent;
        color: #E8640A;
        border-bottom: 1px solid #333;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }
    .table-custom td {
        background: transparent;
        color: #ccc;
        border-bottom: 1px solid #222;
        vertical-align: middle;
    }
    
    /* Efeito hover premium na linha */
    .table-custom tbody tr {
        transition: all 0.3s ease;
    }
    .table-custom tbody tr:hover {
        background-color: rgba(232, 100, 10, 0.08) !important;
    }
    .table-custom tbody tr:hover td {
        color: white;
    }
    
    /* Estilos dos Botões */
    .btn-voltar { 
        background: #222; color: white; border: 1px solid #444; border-radius: 8px; padding: 8px 20px; text-decoration: none; transition: all 0.3s; 
    }
    .btn-voltar:hover { 
        background: #444; color: white; 
    }
    .btn-novo {
        background: #E8640A; color: white; border: 1px solid #E8640A; border-radius: 8px; padding: 8px 20px; text-decoration: none; transition: all 0.3s; font-weight: bold;
    }
    .btn-novo:hover {
        background: #ff7b1f; color: white; box-shadow: 0 0 12px rgba(232, 100, 10, 0.4);
    }
    .btn-acao {
        text-decoration: none;
        padding: 5px 12px;
        border-radius: 6px;
        transition: 0.3s;
        font-size: 0.85rem;
        margin-right: 5px;
        display: inline-block;
    }
    .btn-editar { background: #222; color: #ffc107; border: 1px solid #ffc107; }
    .btn-editar:hover { background: #ffc107; color: black; }
    .btn-excluir { background: #222; color: #dc3545; border: 1px solid #dc3545; }
    .btn-excluir:hover { background: #dc3545; color: white; }
</style>

<div class="container container-custom">
    
    <div class="page-header">
        <h2>🐾 Gestão de <span>Animais</span></h2>
        <div class="botoes-topo">
            <a href="cadastrar.php" class="btn-novo">+ Novo Pet</a>
            <a href="../dashboard.php" class="btn-voltar">⬅ Voltar</a>
        </div>
    </div>

    <div class="table-wrapper table-responsive">
        <table class="table table-custom table-borderless align-middle">
            <thead>
                <tr>
                    <th style="width: 100px;">ID</th>
                    <th>Nome do Pet</th>
                    <th>Espécie</th>
                    <th>Raça</th>
                    <th>Idade</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 220px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(mysqli_num_rows($resultado) > 0){
                    while($animal = mysqli_fetch_assoc($resultado)){
                        // Define as cores do badge de status dinamicamente
                        $status_class = 'bg-success';
                        if ($animal['status'] == 'Lar Temporário') $status_class = 'bg-warning text-dark';
                        if ($animal['status'] == 'Adotado') $status_class = 'bg-primary';

                        echo "<tr>";
                        echo "<td><strong>#". str_pad($animal['id'], 4, '0', STR_PAD_LEFT) ."</strong></td>";
                        echo "<td><strong class='text-white'>{$animal['nome']}</strong></td>";
                        echo "<td><span class='badge bg-dark border border-secondary text-light px-2.5 py-1.5'>{$animal['especie']}</span></td>";
                        
                        // COLUNA CORRIGIDA: Exibe a raça real cadastrada
                        echo "<td><span class='badge bg-dark border border-secondary text-light px-2.5 py-1.5' style='border-color: #444 !important;'>{$animal['raca']}</span></td>";
                        
                        echo "<td>" . ($animal['idade'] !== null ? $animal['idade'] . " ano(s)" : "Não informada") . "</td>";
                        echo "<td><span class='badge {$status_class} px-2 py-1'>{$animal['status']}</span></td>";
                        
                        echo "<td class='text-center'>
                                <a href='editar.php?id={$animal['id']}' class='btn-acao btn-editar' title='Editar Pet'>✏️ Editar</a>
                                <a href='excluir.php?id={$animal['id']}' class='btn-acao btn-excluir' title='Excluir Pet' onclick=\"return confirm('Tem certeza que deseja excluir o pet {$animal['nome']}?');\">🗑️ Excluir</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center py-4' style='color: #666 !important;'>Nenhum animal cadastrado no momento.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<?php 
include '../includes/footer.php'; 
?>