<?php
session_start();
include 'config/conexao.php';

// Verifica se o formulário foi enviado corretamente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario']) && isset($_POST['senha'])) {

    // Sanitiza e protege o usuário digitado contra SQL Injection
    $usuario_input = mysqli_real_escape_string($conn, $_POST['usuario']);
    $senha_input = $_POST['senha'];

    // Busca o voluntário na tabela correspondente do banco de dados
    $sql = "SELECT * FROM voluntarios WHERE usuario = '$usuario_input' AND ativo = TRUE";
    $resultado = mysqli_query($conn, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $voluntario = mysqli_fetch_assoc($resultado);

        // Valida a senha digitada usando a função nativa para senhas criptografadas (BCrypt)
        if (password_verify($senha_input, $voluntario['senha'])) {
            
            // Define as variáveis de sessão essenciais para o funcionamento do sistema
            $_SESSION['usuario'] = $voluntario['usuario'];
            $_SESSION['id_usuario_logado'] = $voluntario['id'];
            $_SESSION['nome_completo'] = $voluntario['nome'];

            // Login bem-sucedido: Redireciona para a dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Senha incorreta
            $_SESSION['erro_login'] = "Usuário ou senha inválidos!";
            header("Location: login.php");
            exit();
        }
    } else {
        // Usuário não encontrado ou inativo
        $_SESSION['erro_login'] = "Usuário ou senha inválidos!";
        header("Location: login.php");
        exit();
    }
} else {
    // Se tentarem acessar o arquivo direto pela URL, manda de volta para o login
    header("Location: login.php");
    exit();
}