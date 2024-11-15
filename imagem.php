<?php
require_once __DIR__ . "/vendor/autoload.php";

// Verifique se o ID do resíduo foi fornecido na URL
if (isset($_GET['idResiduo'])) {
    $idResiduo = $_GET['idResiduo'];

    // Recupere o resíduo a partir do banco de dados
    $residuo = Residuo::find($idResiduo);

    // Verifique se a foto está disponível
    $foto = $residuo->getFoto();  // Aqui, esperamos que getFoto() retorne os dados binários da imagem

    if ($foto) {
        // Defina o tipo de conteúdo adequado
        header('Content-Type: image/jpeg'); // Altere para o tipo correto, dependendo da imagem (JPEG, PNG, etc.)

        // Exiba a imagem diretamente
        echo $foto;
    } else {
        // Caso a foto não exista
        echo "Imagem não encontrada.";
    }
} else {
    echo "ID do resíduo não fornecido.";
}
?>
