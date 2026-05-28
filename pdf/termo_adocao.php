<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../login.php"); exit(); }

// Carrega o autoloader do Composer para o mPDF
require_once '../vendor/autoload.php';
include '../config/conexao.php';
include 'template.php';

if(!isset($_GET['id'])) { die("ID do processo não informado."); }
$id = intval($_GET['id']);

// Busca os dados consolidados: Processo + Animal + Raça + Adotante + Voluntário
$sql = "SELECT p.*, 
        an.nome AS animal_nome, an.sexo, an.idade_categoria, an.descricao,
        er.nome AS raca, er.porte,
        ad.nome AS adotante_nome, ad.cpf, ad.endereco, ad.telefone, ad.email,
        v.nome AS voluntario_nome
        FROM processos_adocao p
        INNER JOIN animais an ON p.animal_id = an.id
        INNER JOIN especies_racas er ON an.especie_id = er.id
        INNER JOIN adotantes ad ON p.adotante_id = ad.id
        INNER JOIN voluntarios v ON p.voluntario_id = v.id
        WHERE p.id = $id";
$resultado = mysqli_query($conn, $sql);
$proc = mysqli_fetch_assoc($resultado);

if(!$proc) { die("Processo de adoção não encontrado."); }

// Montagem do HTML do PDF
$html = "
<style>{$css_padrao}</style>
{$header_padrao}

<h3>TERMO DE RESPONSABILIDADE DE ADOÇÃO</h3>
<p style='text-align: center; font-weight: bold;'>Processo Nº " . str_pad($proc['id'], 4, '0', STR_PAD_LEFT) . "</p>

<h4>1. Dados do Adotante</h4>
<p>
    <strong>Nome Completo:</strong> {$proc['adotante_nome']}<br>
    <strong>CPF:</strong> {$proc['cpf']}<br>
    <strong>Endereço:</strong> {$proc['endereco']}<br>
    <strong>Telefone:</strong> {$proc['telefone']} | <strong>E-mail:</strong> {$proc['email']}
</p>

<h4>2. Dados do Animal</h4>
<p>
    <strong>Nome do Animal:</strong> {$proc['animal_nome']}<br>
    <strong>Espécie/Raça:</strong> {$proc['raca']} | <strong>Porte:</strong> {$proc['porte']}<br>
    <strong>Sexo:</strong> {$proc['sexo']} | <strong>Idade/Categoria:</strong> {$proc['idade_categoria']}<br>
    <strong>Observações Médicas/Comportamentais:</strong> {$proc['descricao']}
</p>

<h4>3. Declaração de Responsabilidade</h4>
<p style='text-align: justify;'>
    Ao assinar este termo, o adotante declara estar ciente de todos os cuidados exigidos para o bem-estar físico e psicológico do animal descrito acima. O adotante compromete-se a:
    <br><br>
    I. Fornecer alimentação adequada, água limpa, abrigo seguro e assistência veterinária sempre que necessário.<br>
    II. Não abandonar, acorrentar ou manter o animal em condições de maus-tratos ou confinamento inadequado.<br>
    III. Comunicar imediatamente à ONG PetMatch em caso de fuga, roubo, adoecimento grave ou óbito do animal.<br>
    IV. Devolver o animal única e exclusivamente para a ONG PetMatch caso haja qualquer impossibilidade de mantê-lo, sendo terminantemente proibido o repasse a terceiros sem prévia autorização.
    <br><br>
    A ONG reserva-se o direito de realizar visitas de acompanhamento e, caso seja constatada qualquer violação destas cláusulas, o animal será imediatamente resgatado, sem prejuízo das sanções legais cabíveis.
</p>

<p>
    <strong>Voluntário Responsável pela Adoção:</strong> {$proc['voluntario_nome']}<br>
    <strong>Data de Abertura do Processo:</strong> " . date("d/m/Y", strtotime($proc['data_abertura'])) . "
</p>

<div class='container-assinaturas'>
    <table style='width: 100%; text-align: center; border: none;'>
        <tr>
            <td style='width: 50%; border: none;'>
                <div class='linha-assinatura'>
                    Representante da ONG PetMatch<br>
                    <span style='font-weight: normal; font-size: 12px;'>Data: ___/___/______</span>
                </div>
            </td>
            <td style='width: 50%; border: none;'>
                <div class='linha-assinatura'>
                    {$proc['adotante_nome']}<br>
                    <span style='font-weight: normal; font-size: 12px;'>Data: ___/___/______</span>
                </div>
            </td>
        </tr>
    </table>
</div>
";

// Geração do PDF
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
// 'I' para exibir no navegador, 'D' para forçar download
$mpdf->Output('Termo_Adocao_'.$proc['id'].'.pdf', 'I');
?>