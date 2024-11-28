<?php
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
        $foto = file_get_contents($_FILES['foto']['tmp_name']);
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

<body>

    <div class="form-cadastro">
        <h1 class="titulo">Editar Resíduo</h1>

        <form action="formEdit.php?idResiduo=<?php echo $_GET['idResiduo']; ?>" method="POST" enctype="multipart/form-data">
            <label for="nome">Nome: </label>
            <input name="nome" value="<?php echo htmlspecialchars($residuo->getNome()); ?>" type="text" required>
            <label for="descricao">Descrição: </label>
            <input name="descricao" value="<?php echo htmlspecialchars($residuo->getDescricao()); ?>" type="text" required>
            <label for="coletor">Coletor: </label>
            <div class="select-coletor">
                <select name="coletor" type="text" required>
                    <option value="default" selected disabled><?php echo htmlspecialchars($residuo->getColetor()); ?></option>
                    <?php if ($residuo->getColetor() !== "Orgânico") { ?><option value="Orgânico">Orgânico</option><?php } ?>
                    <?php if ($residuo->getColetor() !== "Papel") { ?><option value="Papel">Papel</option><?php } ?>
                    <?php if ($residuo->getColetor() !== "Metal") { ?><option value="Metal">Metal</option><?php } ?>
                    <?php if ($residuo->getColetor() !== "Vidro") { ?><option value="Vidro">Vidro</option><?php } ?>
                    <?php if ($residuo->getColetor() !== "Plástico") { ?><option value="Plástico">Plástico</option><?php } ?>
                </select>
            </div>
            <label for="foto">Foto: </label>
            <input type="file" name="foto" accept="image/*">
            <br>
            <!-- ID do resíduo passado como campo oculto -->
            <input name="idResiduo" value="<?php echo $residuo->getIdResiduo(); ?>" type="hidden">
            <div class="botoes">
                <button type="submit" name="botao" onclick="alert('Resíduo editado com sucesso.'); return true;">Salvar</button>
                <br>
                <a href="index.php"><button type="button">Voltar</button></a>
            </div>
        </form>
    </div>





</body>

</html>