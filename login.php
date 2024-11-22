<?php
// Verifica se o formulário foi enviado
if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";
    require_once __DIR__ . "../validacao.php";

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="validacao.php" method="POST">
        Nome de Usuário: <input name="nome" type="text" placeholder="Insira seu nome de usuário" required>
        <br>
        Senha: <input name="senha" type="password" placeholder="Insira sua senha" required>
        <br>
        <input type="submit" name="botao" value="Entrar">
        <br>
        <a href='indexVisitante.php'><button type='button'>Continuar como visitante</button></a>
        <br>
        Não tem uma conta? <a href="formCriarUsuario.php">Criar Conta</a>
    </form>
</body>
</html>