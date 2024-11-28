<?php
// Verifica se o formulário foi enviado
if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";

    // Recupera os valores enviados
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    // Busca o usuário pelo nome
    $usuario = Usuario::findnome($nome);

    if (!$usuario) {
        // Se o usuário não for encontrado, exibe uma mensagem
        echo "Usuário não encontrado!";
        exit;
    }

    // Verifica se a senha é válida
    if (password_verify($senha, $usuario->getSenha())) {
        // Inicia uma sessão e redireciona para a área protegida
        session_start();
        $_SESSION['id'] = $usuario->getIdUsuario();
        header("location: index.php");
        exit;
    } else {
        // Senha inválida
        echo "Senha incorreta!";
        exit;
    }
}
