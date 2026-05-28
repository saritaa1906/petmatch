<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../voluntarios/login.php"); exit(); }
require_once '../config/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Doações - PetMatch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0D0D0D; color: white; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .container-custom { max-width: 600px; margin: 60px auto; }
        .page-header { border-bottom: 2px solid #10B981; padding-bottom: 15px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .page-header h2 { margin: 0; font-weight: bold; color: #f8f9fa; font-size: 1.6rem; }
        .page-header h2 span { color: #10B981; }
        
        .form-wrapper { background: #151515; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.12); border: 1px solid #222; }
        .form-title { color: #10B981; font-weight: 600; font-size: 1.1rem; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 0.5px; }
        
        /* Customização dos Inputs de Data no Dark Mode */
        .form-label-custom { color: #b3b3b3; font-weight: 500; font-size: 0.9rem; margin-bottom: 8px; }
        .input-custom { background: #1a1a1a !important; border: 1px solid #333 !important; color: #fff !important; border-radius: 8px; padding: 10px 12px; transition: 0.3s ease; }
        .input-custom:focus { border-color: #10B981 !important; box-shadow: 0 0 8px rgba(16, 185, 129, 0.3) !important; outline: none; }
        
        /* Ajuste do ícone do calendário nativo do navegador para o modo escuro */
        .input-custom::-webkit-calendar-picker-indicator { filter: invert(1); cursor: pointer; }

        /* Botões */
        .btn-gerar { background: #10B981; color: #000; border-radius: 8px; padding: 12px 24px; font-weight: bold; border: none; width: 100%; transition: 0.3s; font-size: 1rem; }
        .btn-gerar:hover { background: #059669; color: white; box-shadow: 0 0 15px rgba(16, 185, 129, 0.4); }
        .btn-voltar { background: #222; color: white; border: 1px solid #444; border-radius: 8px; padding: 8px 16px; text-decoration: none; transition: 0.3s; font-size: 0.9rem; }
        .btn-voltar:hover { background: #333; color: white; }
    </style>
</head>
<body>
<div class="container container-custom">
    
    <div class="page-header">
        <h2>📊 Relatório de <span>Doações</span></h2>
        <a href="listar.php" class="btn-voltar">⬅ Voltar</a>
    </div>
    
    <div class="form-wrapper">
        <div class="form-title">Filtrar Prestação de Contas por Período</div>
        
        <form action="gerar_pdf.php" method="GET">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="data_inicial" class="form-label form-label-custom">Data Inicial *</label>
                    <input type="date" name="data_inicial" id="data_inicial" class="form-control input-custom" required value="<?php echo date('Y-m-01'); ?>">
                </div>
                
                <div class="col-md-6 mb-4">
                    <label for="data_final" class="form-label form-label-custom">Data Final *</label>
                    <input type="date" name="data_final" id="data_final" class="form-control input-custom" required value="<?php echo date('Y-m-t'); ?>">
                </div>
            </div>
            
            <button type="submit" class="btn-gerar mt-2">
                📄 Gerar Prestação de Contas em PDF
            </button>
        </form>
    </div>

</div>
</body>
</html>