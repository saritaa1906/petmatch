<?php
session_start();
if(!isset($_SESSION['usuario'])) { header("Location: ../voluntarios/login.php"); exit(); }

require_once '../config/conexao.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adotante_id = $_POST['adotante_id'];
    $valor = $_POST['valor'];
    $data_doacao = $_POST['data_doacao'];
    $tipo = $_POST['tipo'];
    $descricao = $_POST['descricao'];

    $stmt = $conn->prepare("INSERT INTO doacoes (adotante_id, valor, data_doacao, tipo, descricao) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("idsss", $adotante_id, $valor, $data_doacao, $tipo, $descricao);
    
    if($stmt->execute()) {
        header("Location: listar.php");
        exit();
    } else {
        $erro = "Erro ao cadastrar doação: " . $conn->error;
    }
}

// Busca todos os adotantes para preencher o select do formulário
$adotantes = $conn->query("SELECT id, nome FROM adotantes ORDER BY nome ASC");
include '../includes/header.php';
include '../includes/menu.php';
?>

<div class="content-wrapper" style="background-color: #0D0D0D; min-height: 100vh; padding: 20px; color: #fff;">
    <div class="container-fluid">
        
        <div class="d-flex justify-content-between align-items-center mb-4" style="border-bottom: 2px solid #E8640A; padding-bottom: 10px;">
            <h2 style="color: #fff; margin: 0;">➕ Registrar Nova Doação</h2>
            <a href="listar.php" class="btn" style="background-color: #0A3D91; color: white;">Voltar</a>
        </div>

        <?php if(isset($erro)): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>

        <div class="card" style="background-color: #1a1a1a; border: 1px solid #333; border-radius: 10px;">
            <div class="card-body p-4">
                <form action="cadastrar.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="color: #ccc;">Doador (Adotante) *</label>
                            <select class="form-control" name="adotante_id" required style="background-color: #2b2b2b; color: #fff; border: 1px solid #444;">
                                <option value="">Selecione o Adotante...</option>
                                <?php while($a = $adotantes->fetch_assoc()): ?>
                                    <option value="<?php echo $a['id']; ?>"><?php echo htmlspecialchars($a['nome']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="color: #ccc;">Valor (R$) *</label>
                            <input type="number" step="0.01" class="form-control" name="valor" placeholder="0.00" required style="background-color: #2b2b2b; color: #fff; border: 1px solid #444;">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="color: #ccc;">Data da Doação *</label>
                            <input type="date" class="form-control" name="data_doacao" value="<?php echo date('Y-m-d'); ?>" required style="background-color: #2b2b2b; color: #fff; border: 1px solid #444;">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="color: #ccc;">Forma de Pagamento *</label>
                            <select class="form-control" name="tipo" required style="background-color: #2b2b2b; color: #fff; border: 1px solid #444;">
                                <option value="PIX">PIX</option>
                                <option value="Transferência">Transferência</option>
                                <option value="Dinheiro">Dinheiro</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label" style="color: #ccc;">Observação / Finalidade</label>
                            <textarea class="form-control" name="descricao" rows="3" style="background-color: #2b2b2b; color: #fff; border: 1px solid #444;"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn" style="background-color: #E8640A; color: white; font-weight: bold; width: 150px;">Salvar</button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include '../includes/footer.php'; ?>