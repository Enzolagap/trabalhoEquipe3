<?php
// Verifica se o formulário foi enviado
if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";
    require_once __DIR__ . "../validacao.php";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container-login">
        <!-- Formulário -->
        <div class="form-login">

            <img src='http://localhost/trabalhoEquipe3-main/Imagens/Logo.png' width='300px'>

            <form action="validacao.php" method="POST">
                <br>
                <label for="nome">Nome de Usuário:</label>
                <input name="nome" type="text" placeholder="Insira seu nome de usuário" required>
                <label for="senha">Senha:</label>
                <input name="senha" type="password" placeholder="Insira sua senha" required>
                <button type="submit" name="botao">Entrar</button>
                <br>
                <a href='indexVisitante.php'><button type='button'>Voltar a tela inicial</button></a>
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