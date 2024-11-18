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
    $coletor = $_POST['coletor'];
    $foto = null; // Inicializa como null para garantir que não seja sobrescrito acidentalmente
    
    // Se uma nova foto foi enviada, pega o conteúdo da foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = file_get_contents($_FILES['foto']['tmp_name']);
    }
    
    // Atualiza os dados do resíduo com as novas informações
    $residuo->setNome($nome);
    $residuo->setDescricao($descricao);
    $residuo->setColetor($coletor);
    
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edita Resíduo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="formEdit.php?idResiduo=<?php echo $_GET['idResiduo']; ?>" method="POST" enctype="multipart/form-data">
        Nome: <input name="nome" value="<?php echo htmlspecialchars($residuo->getNome()); ?>" type="text" required>
        <br>
        Descrição: <input name="descricao" value="<?php echo htmlspecialchars($residuo->getDescricao()); ?>" type="text" required>
        <br>
        Coletor: <input name="coletor" value="<?php echo htmlspecialchars($residuo->getColetor()); ?>" type="text" required>
        <br>

        <!-- Exibe a foto atual (se houver) no formulário -->
        <?php if ($residuo->getFoto() !== null) { ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($residuo->getFoto()); ?>" width="100" height="100" />
            <br>
        <?php } ?>

        Foto: <input type="file" name="foto" accept="image/*">
        <br>
        
        <!-- ID do resíduo passado como campo oculto -->
        <input name="idResiduo" value="<?php echo $residuo->getIdResiduo(); ?>" type="hidden">
        <br>
        
        <input type="submit" name="botao" value="Salvar">

        <a href="index.php"><button type="button">Voltar</button></a>
    </form>
</body>
</html>
