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
    header("location: formCad.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Resíduo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class='container'>
<div class="form-cadastro">
        <h1 class="titulo">Cadastrar Resíduo</h1>

        <form action="formCad.php" method="POST" enctype="multipart/form-data">
            <label for="nome">Nome: </label>
            <input name="nome" type="text" required>
            <label for="descricao">Descrição: </label>
            <input name="descricao" type="text" required>
            <label for="coletor">Coletor: </label>
            <div class="select-coletor">
                <select name="coletor" type="text" required>
                    <option value="default" selected disabled>Selecionar coletor</option>
                    <option value="Papel">Papel</option>
                    <option value="Plástico">Plástico</option>
                    <option value="Orgânico">Orgânico</option>
                    <option value="Metal">Metal</option>
                    <option value="Vidro">Vidro</option>
                </select>
            </div>
            <label for="foto">Foto: (resolução recomendada: 412x412)</label>
            <input type="file" name="foto" id="imageInput" accept="image/*" required>
            <br>
            <div class="botoes">
                <button type="submit" name="botao" onclick="alert('Resíduo cadastrado com sucesso.'); return true;">Cadastrar</button>
                <br>
                <a href="index.php"><button type="button">Voltar</button></a>
            </div>
        </form>
    </div>


</div>
</body>
</html>
