<?php
// template.php - Contém o cabeçalho e CSS padrão para os PDFs do PetMatch

$css_padrao = "
    body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 14px; }
    h1, h2, h3, h4 { color: #0A3D91; text-align: center; margin-bottom: 10px; }
    p { line-height: 1.5; }
    .header-ong { text-align: center; border-bottom: 2px solid #E8640A; padding-bottom: 10px; margin-bottom: 25px; }
    .header-ong h2 { margin: 0; color: #0A3D91; font-size: 24px; }
    .header-ong p { margin: 5px 0 0 0; font-size: 12px; color: #555; }
    
    /* Estilos para Tabelas */
    .tabela { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 13px; }
    .tabela th, .tabela td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    .tabela th { background-color: #f8f9fa; color: #0A3D91; font-weight: bold; }
    .tabela tr:nth-child(even) { background-color: #fcfcfc; }
    
    /* Estilos para Assinaturas */
    .container-assinaturas { width: 100%; margin-top: 60px; text-align: center; }
    .assinatura { width: 45%; display: inline-block; vertical-align: top; }
    .linha-assinatura { border-top: 1px solid #000; margin-top: 40px; padding-top: 5px; font-weight: bold; }
";

$header_padrao = "
    <div class='header-ong'>
        <h2>🐾 PetMatch ONG</h2>
        <p>Sistema de Adoção de Animais e Gestão Integrada<br>
        contato@petmatch.ong.br | (11) 99999-9999</p>
    </div>
";
?>