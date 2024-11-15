<?php
// Verifica se o formulário foi enviado
if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";
    
    // Verifica se uma foto foi enviada
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = file_get_contents($_FILES['foto']['tmp_name']); // Obtém o conteúdo do arquivo
    }

    // Cria o resíduo com os dados fornecidos
    $residuo = new Residuo($_POST['descricao'], $_POST['coletor'], $_POST['nome'], $foto);
    
    // Salva o resíduo no banco de dados
    $residuo->save();
    
    // Após salvar, redireciona para a página de listagem
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
    <title>Cadastrar Resíduo</title>
</head>
<body>
    <form action="formCad.php" method="POST" enctype="multipart/form-data">
        Nome: <input name="nome" type="text" required>
        <br>
        Descrição: <input name="descricao" type="text" required>
        <br>
        Coletor: <input name="coletor" type="text" required>
        <br>
        Foto: <input type="file" name="foto" accept="image/*">
        <br>
        <input type="submit" name="botao" value="Cadastrar">
    </form>
</body>
</html>
