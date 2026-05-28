<?php
session_start();
if(!isset($_SESSION['usuario'])) { 
    header("Location: ../login.php"); // Corrigido para apontar para o login da raiz
    exit(); 
}

include '../config/conexao.php';

// VARIÁVEIS DE CONFIGURAÇÃO DO INCLUDES (Tema Vermelho para Voluntários)
$titulo_pagina = "Voluntários - PetMatch";
$cor_modulo    = "#DC3545"; // Vermelho Coral

include '../includes/header.php';
include '../includes/menu.php';

$sql = "SELECT id, nome, usuario FROM voluntarios ORDER BY id DESC";
$resultado = mysqli_query($conn, $sql);
?>

<style>
    .container-custom { max-width: 1000px; margin: 50px auto; }
    .page-header { border-bottom: 2px solid #DC3545; padding-bottom: 15px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
    .page-header h2 { margin: 0; font-weight: bold; color: #f8f9fa; }
    .page-header h2 span { color: #DC3545; text-shadow: 0 0 10px rgba(220, 53, 69, 0.3); }
    
    .table-wrapper { background: #151515; border-radius: 15px; padding: 20px; box-shadow: 0 10px 30px rgba(220, 53, 69, 0.1); border: 1px solid #222; }
    .table-custom { --bs-table-bg: transparent; margin-bottom: 0; }
    .table-custom th { color: #DC3545 !important; border-bottom: 2px solid #333 !important; font-weight: 600; text-transform: uppercase; font-size: 0.9rem; background: transparent !important; }
    .table-custom td { color: #ccc !important; border-bottom: 1px solid #222 !important; vertical-align: middle; background: transparent !important; }
    
    .table-custom tbody tr { transition: all 0.3s ease; }
    .table-custom tbody tr:hover { background-color: rgba(220, 53, 69, 0.08) !important; }
    .table-custom tbody tr:hover td { color: #fff !important; }
    
    .btn-novo { background: #DC3545; color: white; border-radius: 8px; padding: 8px 20px; font-weight: bold; text-decoration: none; transition: 0.3s; border: none; }
    .btn-novo:hover { background: #bb2d3b; color: white; box-shadow: 0 0 12px rgba(220, 53, 69, 0.4); }
    .btn-voltar { background: #222; color: white; border: 1px solid #444; border-radius: 8px; padding: 8px 20px; text-decoration: none; transition: 0.3s; }
    .btn-voltar:hover { background: #333; color: white; }
    
    .btn-acao { text-decoration: none; padding: 5px 12px; border-radius: 6px; font-size: 0.85rem; margin-right: 4px; transition: 0.3s; display: inline-block; }
    .btn-editar { background: #222; color: #ffc107; border: 1px solid #ffc107; }
    .btn-editar:hover { background: #ffc107; color: #000; }
    .btn-excluir { background: #222; color: #dc3545; border: 1px solid #dc3545; }
    .btn-excluir:hover { background: #dc3545; color: #fff; }
</style>

<div class="container container-custom">
    <div class="page-header">
        <h2>🤝 Equipe de <span>Voluntários</span></h2>
        <div class="d-flex gap-2">
            <a href="cadastrar.php" class="btn-novo">+ Novo Voluntário</a>
            <a href="../dashboard.php" class="btn-voltar">⬅ Voltar</a>
        </div>
    </div>

    <div class="table-wrapper table-responsive">
        <table class="table table-custom table-borderless align-middle">
            <thead>
                <tr>
                    <th style="width: 100px;">ID</th>
                    <th>Nome Completo</th>
                    <th>Usuário de Acesso</th>
                    <th class="text-center" style="width: 220px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Proteção contra query falhada (Retorna false se a tabela não existir)
                if($resultado && mysqli_num_rows($resultado) > 0){
                    while($vol = mysqli_fetch_assoc($resultado)){
                        echo "<tr>";
                        echo "<td><strong>#". str_pad($vol['id'], 4, '0', STR_PAD_LEFT) ."</strong></td>";
                        echo "<td><strong class='text-white'>{$vol['nome']}</strong></td>";
                        echo "<td><span class='badge bg-dark border border-secondary text-light px-2.5 py-1.5'>@{$vol['usuario']}</span></td>";
                        
                        echo "<td class='text-center'>";
                        echo "<a href='editar.php?id={$vol['id']}' class='btn-acao btn-editar' title='Editar'>✏️ Editar</a>";
                        
                        if($vol['usuario'] != $_SESSION['usuario']) {
                            echo "<a href='excluir.php?id={$vol['id']}' class='btn-acao btn-excluir' title='Excluir' onclick=\"return confirm('Tem certeza que deseja remover o voluntário {$vol['nome']}?');\">🗑️ Excluir</a>";
                        } else {
                            echo "<span class='badge bg-secondary text-white-50 p-2'>Você</span>";
                        }
                        echo "</td></tr>";
                    }
                } else if (!$resultado) {
                    // Exibe uma mensagem amigável caso a tabela falhe em carregar
                    echo "<tr><td colspan='4' class='text-center py-4 alert alert-danger' style='background: transparent !important;'>⚠️ Erro crítico: A tabela 'voluntarios' não foi encontrada no Banco de Dados. Por favor, execute o comando SQL de criação.</td></tr>";
                } else {
                    echo "<tr><td colspan='4' class='text-center py-4' style='color: #666 !important;'>Nenhum voluntário cadastrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>