<?php
// Verifica se o formulário foi enviado
if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";

    // Cria o usuario com os dados fornecidos
    $usuario = new Residuo($_POST['email'], $_POST['senha'], $_POST['nome']);
    
    //Sanitiza as variáveis recebidas
    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $senha = htmlspecialchars($_POST['senha']);

    //Gera uma variável criptografada
    $password_hash = password_hash($_POST['senha'],PASSWORD_BCRYPT);
    
    // Salva o usuario no banco de dados
    $usuario->save();
    
    // Após salvar, redireciona para a página de login
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
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
        Email: <input name="email" type="text" placeholder="Insira seu email" required>
        <br>
        Senha: <input name="senha" type="text" placeholder="Crie uma senha"  required >
        <br>
        <input type="submit" name="botao" value="Criar conta">
        <br>
       Já tem uma conta? <a href='formLogin.php'>Fazer login</a>
    </form>
</body>
</html>
