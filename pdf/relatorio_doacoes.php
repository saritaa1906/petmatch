<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../voluntarios/login.php"); exit(); }

// Carrega o autoload do Composer que instalamos!
require_once '../vendor/autoload.php';
require_once '../config/conexao.php';

$data_inicial = $_GET['data_inicial'] ?? date('Y-m-01');
$data_final = $_GET['data_final'] ?? date('Y-m-t');

// Query buscando dados estruturados do período selecionado
$query = "SELECT d.*, a.nome AS nome_adotante 
          FROM doacoes d 
          INNER JOIN adotantes a ON d.adotante_id = a.id 
          WHERE d.data_doacao BETWEEN ? AND ?
          ORDER BY d.data_doacao ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $data_inicial, $data_final);
$stmt->execute();
$result = $stmt->get_result();

// Formatação amigável das datas para o cabeçalho do PDF
$d_ini = date('d/m/Y', strtotime($data_inicial));
$d_fim = date('d/m/Y', strtotime($data_final));

// Montagem do HTML estruturado (CSS inline para compatibilidade do mPDF)
$html = "
<div style='font-family: Arial, sans-serif; color: #333;'>
    <div style='text-align: center; border-bottom: 2px solid #E8640A; padding-bottom: 15px; mb-20px;'>
        <h1 style='color: #0A3D91; margin: 0; font-size: 26px;'>PetMatch — Sistema de Gestão de ONGs</h1>
        <p style='margin: 5px 0 0 0; color: #666; font-size: 14px;'>Relatório de Prestação de Contas — Entrada de Doações</p>
        <p style='margin: 5px 0 0 0; font-weight: bold;'>Período: $d_ini até $d_fim</p>
    </div>

    <table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>
        <thead>
            <tr style='background-color: #0A3D91; color: white;'>
                <th style='padding: 10px; border: 1px solid #ddd; text-align: center;'>ID</th>
                <th style='padding: 10px; border: 1px solid #ddd; text-align: left;'>Doador (Adotante)</th>
                <th style='padding: 10px; border: 1px solid #ddd; text-align: center;'>Data</th>
                <th style='padding: 10px; border: 1px solid #ddd; text-align: center;'>Método</th>
                <th style='padding: 10px; border: 1px solid #ddd; text-align: right;'>Valor</th>
            </tr>
        </thead>
        <tbody>";

$total = 0;
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id_fmt = str_pad($row['id'], 3, '0', STR_PAD_LEFT);
        $nome = htmlspecialchars($row['nome_adotante']);
        $data = date('d/m/Y', strtotime($row['data_doacao']));
        $tipo = htmlspecialchars($row['tipo']);
        $valor_fmt = number_format($row['valor'], 2, ',', '.');
        $total += $row['valor'];

        $html .= "
        <tr style='border-bottom: 1px solid #ddd;'>
            <td style='padding: 8px; text-align: center; border: 1px solid #ddd; color: #666;'>#$id_fmt</td>
            <td style='padding: 8px; border: 1px solid #ddd;'>$nome</td>
            <td style='padding: 8px; text-align: center; border: 1px solid #ddd;'>$data</td>
            <td style='padding: 8px; text-align: center; border: 1px solid #ddd;'>$tipo</td>
            <td style='padding: 8px; text-align: right; border: 1px solid #ddd; font-weight: bold; color: #2e7d32;'>R$ $valor_fmt</td>
        </tr>";
    }
} else {
    $html .= "<tr><td colspan='5' style='padding: 20px; text-align: center; color: #888;'>Nenhum registro encontrado no período selecionado.</td></tr>";
}

$total_fmt = number_format($total, 2, ',', '.');

$html .= "
        </tbody>
    </table>

    <div style='margin-top: 30px; text-align: right; background-color: #f5f5f5; padding: 15px; border-left: 5px solid #E8640A;'>
        <span style='font-size: 16px; font-weight: bold; color: #555;'>VALOR TOTAL CONSOLIDADO: </span>
        <span style='font-size: 20px; font-weight: bold; color: #0A3D91;'>R$ $total_fmt</span>
    </div>

    <div style='margin-top: 50px; text-align: center; font-size: 11px; color: #888; border-top: 1px solid #ddd; padding-top: 10px;'>
        Documento gerado automaticamente pelo módulo PetMatch em " . date('d/m/Y H:i') . "
    </div>
</div>";

// Inicializa a classe mPDF e renderiza o arquivo diretamente na tela
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output("Relatorio_Doacoes_" . date('Ymd') . ".pdf", \Mpdf\Output\Destination::INLINE);