<?php
// Verifica se o formulário foi enviado
if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";

    // Verifica se uma foto foi enviada e valida o tipo
    $tipos_permitidos = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp', 'image/jfif', 'image/tiff', 'image/psd', 'image/bmp'];
    $foto = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $tipo_arquivo = mime_content_type($_FILES['foto']['tmp_name']);

        // Verifica se o tipo de arquivo é permitido
        if (!in_array($tipo_arquivo, $tipos_permitidos)) {
            echo "Tipo de imagem inválido. Por favor, envie uma imagem válida (JPG, PNG, WebP, etc.).";
            exit;
        }

        // Se o tipo for válido, lê o conteúdo do arquivo de imagem
        $foto = file_get_contents($_FILES['foto']['tmp_name']); // Obtém o conteúdo do arquivo
    }

    // Cria o resíduo com os dados fornecidos
    $residuo = new Residuo($_POST['descricao'], $_POST['coletor'], $_POST['nome'], $foto);

    // Salva o resíduo no banco de dados
    $residuo->save();

    // Após salvar, redireciona para a página de cadastro, resetando os campos
    header("location: formCad.php?success=true");
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

<script>
    function validarFoto(event) {
        var foto = event.target.files[0]; // Obtém o arquivo enviado
        var tiposPermitidos = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp', 'image/jfif', 'image/tiff', 'image/psd', 'image/bmp'];

        // Verifica se há uma foto e se o tipo do arquivo está correto
        if (foto) {
            var tipoArquivo = foto.type;

            console.log("Tipo de arquivo: " + tipoArquivo); // Debug

            // Se o tipo do arquivo não for permitido
            if (!tiposPermitidos.includes(tipoArquivo)) {
                alert('Tipo de imagem inválido. Por favor, envie uma imagem válida (JPG, PNG, WebP, etc.).');
                event.target.value = ""; // Limpa o campo de imagem
                return false; // Impede o envio do formulário
            }
        }

        return true; // Permite o envio do formulário
    }

    function validarFormularioCadastro(event) {

        var foto = document.forms["formCad"]["foto"].files[0]; // Acessa o arquivo de imagem enviado
        var tiposPermitidos = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp', 'image/jfif', 'image/tiff', 'image/psd', 'image/bmp'];

        // Verifica se a foto é válida
        if (foto) {
            var tipoArquivo = foto.type;

            if (!tiposPermitidos.includes(tipoArquivo)) {
                event.preventDefault(); // Impede o envio do formulário, aguardando validação
                alert('Tipo de imagem inválido. Por favor, envie uma imagem válida (JPG, PNG, WebP, etc.).');
                return false; // Impede o envio do formulário
            }
        }

        // Se tudo estiver correto, envia o formulário
        alert('Resíduo cadastrado com sucesso!');
        document.forms["formCad"].submit(); // Envia o formulário
        return true;
    }
</script>

<body>
    <div class='container'>
        <div class="form-cadastro">
            <h1 class="titulo">Cadastrar Resíduo</h1>

            <form name="formCad" action="formCad.php" method="POST" enctype="multipart/form-data" onsubmit="return validarFormularioCadastro(event)">
                <label for="nome">Nome: </label>
                <input name="nome" type="text" required>

                <label for="descricao">Descrição: </label>
                <input name="descricao" type="text" required>

                <label for="coletor">Coletor: </label>
                <div class="select-coletor">
                    <select name="coletor" required>
                        <option value="default" selected disabled>Selecionar coletor</option>
                        <option value="Papel">Papel</option>
                        <option value="Plástico">Plástico</option>
                        <option value="Orgânico">Orgânico</option>
                        <option value="Metal">Metal</option>
                        <option value="Vidro">Vidro</option>
                    </select>
                </div>

                <label for="foto">Foto: (resolução recomendada: 412x412)</label>
                <input type="file" name="foto" id="imageInput" accept="image/*" onchange="validarFoto(event)" required>
                <br>

                <div class="botoes">
                    <button type="submit" name="botao">Cadastrar</button>
                    <br>
                    <a href="index.php"><button type="button">Voltar</button></a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>