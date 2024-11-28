<?php

$tipos_permitidos = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp', 'image/jfif', 'image/tiff', 'image/psd', 'image/bmp'];
// Verifica se o ID do resíduo foi passado na URL
if (isset($_GET['idResiduo'])) {
    require_once __DIR__ . "/vendor/autoload.php";

    // Tenta encontrar o resíduo pelo ID
    $residuo = Residuo::find($_GET['idResiduo']);

    // Se o resíduo não for encontrado, exibe uma mensagem e encerra o script
    if (!$residuo) {
        echo "Resíduo não encontrado!";
        exit;
    }
} else {
    // Se o ID não foi passado na URL, exibe uma mensagem e encerra o script
    echo "ID do resíduo não fornecido!";
    exit;
}

// Processa o formulário quando o botão de envio for pressionado
if (isset($_POST['botao'])) {
    require_once __DIR__ . "/vendor/autoload.php";

    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $coletor = $_POST['coletor'] ?? null; // Captura o valor do coletor enviado pelo formulário
    $foto = null; // Inicializa como null para garantir que não seja sobrescrito acidentalmente

    // Se uma nova foto foi enviada, pega o conteúdo da foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $tipo_arquivo = mime_content_type($_FILES['foto']['tmp_name']);

        if (in_array($tipo_arquivo, $tipos_permitidos)) {
            // Lê o conteúdo do arquivo de imagem e converte em binário
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
        } else {
            // Redireciona de volta para o formulário caso o tipo de arquivo não seja permitido
            header("location: formEdit.php?idResiduo=" . $_GET['idResiduo'] . "&erro=tipo");
            exit;
        }
    }

    // Atualiza os dados do resíduo com as novas informações
    $residuo->setNome($nome);
    $residuo->setDescricao($descricao);

    // Se um novo coletor foi fornecido, atualiza o coletor
    if ($coletor !== null) {
        $residuo->setColetor($coletor);
    }

    // Se uma nova foto foi carregada, atualiza a foto
    if ($foto !== null) {
        $residuo->setFoto($foto);
    }

    // Salva o resíduo atualizado no banco de dados
    $residuo->save();

    // Após salvar, redireciona para a página de listagem
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edita Resíduo</title>
    <link rel="stylesheet" href="style.css">
</head>

<script>
    // Função que será chamada na submissão do formulário
    function validarFormulario(event) {
        event.preventDefault(); // Impede o envio do formulário

        var foto = document.forms["formEdit"][<?php echo $residuo->getFoto(); ?>].files[0];
        var tiposPermitidos = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp', 'image/jfif', 'image/tiff', 'image/psd', 'image/bmp'];

        if (foto) {
            var tipoArquivo = foto.type;

            console.log("Tipo de arquivo: " + tipoArquivo); // Debug

            // Se o tipo do arquivo não for permitido
            if (!tiposPermitidos.includes(tipoArquivo)) {
                alert('Tipo de imagem inválido. Por favor, envie uma imagem válida (JPG, PNG, WebP, etc.).');
                return false; // Impede o envio do formulário
            }
        }

        // Se tudo estiver correto, envia o formulário
        alert('Resíduo editado com sucesso!');
        document.forms["formEdit"].submit(); // Envia o formulário
        return true;
    }
</script>

<body>
    <div class='container'>
        <div class="form-cadastro">
            <h1 class="titulo">Editar Resíduo</h1>
            <form action="formEdit.php?idResiduo=<?php echo $_GET['idResiduo']; ?>" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario(event);">
                <label for="nome">Nome: </label>
                <input name="nome" value="<?php echo htmlspecialchars($residuo->getNome()); ?>" type="text" required>
                <label for="descricao">Descrição: </label>
                <input name="descricao" value="<?php echo htmlspecialchars($residuo->getDescricao()); ?>" type="text" required>
                <label for="coletor">Coletor: </label>
                <div class="select-coletor">
                    <select name="coletor" type="text" required>
                        <option selected><?php echo htmlspecialchars($residuo->getColetor()); ?></option>
                        <?php if ($residuo->getColetor() !== "Orgânico") { ?><option value="Orgânico">Orgânico</option><?php } ?>
                        <?php if ($residuo->getColetor() !== "Papel") { ?><option value="Papel">Papel</option><?php } ?>
                        <?php if ($residuo->getColetor() !== "Metal") { ?><option value="Metal">Metal</option><?php } ?>
                        <?php if ($residuo->getColetor() !== "Vidro") { ?><option value="Vidro">Vidro</option><?php } ?>
                        <?php if ($residuo->getColetor() !== "Plástico") { ?><option value="Plástico">Plástico</option><?php } ?>
                    </select>
                </div>
                <label for="id">Foto: </label>
                <input type="file" name="foto" id="foto" accept="image/*">
                <br>
                <!-- ID do resíduo passado como campo oculto -->
                <input name="idResiduo" value="<?php echo $residuo->getIdResiduo(); ?>" type="hidden">
                <div class="botoes">
                    <button type="submit" name="botao">Salvar</button>
                    <br>
                    <a href="index.php"><button type="button">Voltar</button></a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>