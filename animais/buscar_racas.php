<?php
include '../config/conexao.php';

if (isset($_GET['especie_id'])) {
    $especie_id = intval($_GET['especie_id']);
    
    // Busca as raças da espécie selecionada
    $query = mysqli_query($conn, "SELECT id, nome FROM racas WHERE especie_id = $especie_id ORDER BY nome ASC");
    
    $racas = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $racas[] = $row;
    }
    
    header('Content-Type: application/json');
    echo json_encode($racas);
    exit;
}