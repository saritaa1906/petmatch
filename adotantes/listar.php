<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../voluntarios/login.php"); // Caminho ajustado para a pasta voluntários
    exit();
}

include '../config/conexao.php';

// VARIÁVEIS DE CONFIGURAÇÃO DO INCLUDES (Tema Azul para o módulo de Adotantes)
$titulo_pagina = "Adotantes - PetMatch";
$cor_modulo    = "#0A3D91"; // Azul Real da identidade dos Adotantes

include '../includes/header.php';
include '../includes/menu.php';

$sql = "SELECT * FROM adotantes ORDER BY id DESC";
$resultado = mysqli_query($conn, $sql);
?>

<style>
    .container-custom {
        max-width: 1000px;
        margin: 50px auto;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #0A3D91; /* Azul */
        padding-bottom: 15px;
        margin-bottom: 30px;
    }
    .page-header h2 {
        margin: 0;
        font-weight: bold;
        color: #f8f9fa;
    }
    .page-header h2 span {
        color: #4A90E2; /* Azul claro */
        text-shadow: 0 0 10px rgba(10, 61, 145, 0.5);
    }
    .botoes-topo {
        display: flex;
        gap: 10px;
    }
    .table-wrapper {
        background: #151515;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(10, 61, 145, 0.15); /* Sombra Azul */
    }
    .table-custom {
        color: white;
        margin-bottom: 0;
    }
    .table-custom th {
        background: transparent;
        color: #4A90E2;
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
    
    /* Animação suave na linha quando passa o mouse por cima */
    .table-custom tbody tr {
        transition: all 0.3s ease;
    }
    .table-custom tbody tr:hover {
        background-color: rgba(10, 61, 145, 0.12) !important;
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
        background: #0A3D91; color: white; border: 1px solid #0A3D91; border-radius: 8px; padding: 8px 20px; text-decoration: none; transition: all 0.3s; font-weight: bold;
    }
    .btn-novo:hover {
        background: #4A90E2; color: white; box-shadow: 0 0 10px rgba(74, 144, 226, 0.4);
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
        <h2>👤 Lista de <span>Adotantes</span></h2>
        <div class="botoes-topo">
            <a href="cadastrar.php" class="btn-novo">+ Novo Adotante</a>
            <a href="../dashboard.php" class="btn-voltar">⬅ Voltar</a>
        </div>
    </div>

    <div class="table-wrapper table-responsive">
        <table class="table table-custom table-borderless align-middle">
            <thead>
                <tr>
                    <th style="width: 100px;">ID</th>
                    <th>Nome do Adotante</th>
                    <th>Email de Contato</th>
                    <th class="text-center" style="width: 220px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(mysqli_num_rows($resultado) > 0){
                    while($adotante = mysqli_fetch_assoc($resultado)){
                        echo "<tr>";
                        echo "<td><strong>#". str_pad($adotante['id'], 4, '0', STR_PAD_LEFT) ."</strong></td>";
                        echo "<td><strong class='text-white'>{$adotante['nome']}</strong></td>";
                        echo "<td>{$adotante['email']}</td>";
                        
                        echo "<td class='text-center'>
                                <a href='editar.php?id={$adotante['id']}' class='btn-acao btn-editar' title='Editar Adotante'>✏️ Editar</a>
                                <a href='excluir.php?id={$adotante['id']}' class='btn-acao btn-excluir' title='Excluir Adotante' onclick=\"return confirm('Tem certeza que deseja excluir o adotante {$adotante['nome']}?');\">🗑️ Excluir</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center py-4' style='color: #666 !important;'>Nenhum adotante cadastrado no momento.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<?php 
include '../includes/footer.php'; 
?>