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

    <div class="container-login">
        <!-- Formulário -->
        <div class="form-login">

        <img src='http://localhost/trabalhoEquipe3-main/Imagens/Logo.png' width='300px'>

            <form action="formCriarUsuario.php" method="POST">
                <br>
                <label for="nome">Nome de Usuário:</label>
                <input name="nome" type="text" placeholder="Crie um nome de usuário" required>
                <label for="email">Email:</label>
                <input name="email" type="email" placeholder="Insira seu email" required>
                <label for="senha">Senha:</label>
                <input name="senha" type="password" placeholder="Crie uma senha" required>
                <a href="login.php"><button type="submit" name="botao">Criar Conta</button></a>
                <br>
                <div class="criar-conta">
                    Já tem uma conta? <a href='login.php'>Fazer login</a>
                </div>
            </form>
        </div>

        <!-- Imagem e texto -->
        <div class="image-container">
            <img src='http://localhost/trabalhoEquipe3-main/Imagens/Background.jpg'>
            <div class="image-overlay">
                <h2><span class="highlight">Reciclar</span> faz parte da lição.</h2>
            </div>
        </div>
    </div>

</body>
</html>
