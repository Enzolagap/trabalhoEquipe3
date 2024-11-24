<?php
// Verifica se o formulário foi enviado
if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";

    // Sanitiza os dados recebidos
    $nome = htmlspecialchars(trim($_POST['nome']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha']);

    // Verifica se o e-mail é válido
    if (!$email) {
        die("E-mail inválido! Tente novamente.");
    }

    // Gera um hash seguro para a senha
    $password_hash = password_hash($senha, PASSWORD_BCRYPT);

    // Cria o usuário com os dados fornecidos
    $usuario = new Usuario($nome, $email, $password_hash);

    // Salva o usuário no banco de dados
    $usuario->save();

    // Redireciona para a página de login
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="formCriarUsuario.php" method="POST" >
        Nome de Usuário: <input name="nome" type="text" placeholder="Crie um nome de usuário" required>
        <br>
        Email: <input name="email" type="email" placeholder="Insira seu email" required>
        <br>
        Senha: <input name="senha" type="password" placeholder="Crie uma senha"  required >
        <br>
        <input type="submit" name="botao" value="Criar conta">
        <br>
       Já tem uma conta? <a href='login.php'>Fazer login</a>
    </form>
</body>
</html>
