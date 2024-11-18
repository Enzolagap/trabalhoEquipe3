<?php
require_once __DIR__ . "/vendor/autoload.php";

// Verifica se há uma pesquisa sendo feita
if (isset($_POST['search']) && isset($_POST['type'])) {
    $searchTerm = $_POST['search'];
    $type = $_POST['type'];
    
    // Filtra os resíduos com base no tipo escolhido (nome, descricao, coletor)
    if ($type == 'nome') {
        $residuos = Residuo::findnome($searchTerm);
    } elseif ($type == 'descricao') {
        $residuos = Residuo::finddescricao($searchTerm);
    } elseif ($type == 'coletor') {
        $residuos = Residuo::findcoletor($searchTerm);
    }
} else {
    // Se não houver filtro, exibe todos os resíduos
    $residuos = Residuo::findall();
}

// Função para obter a cor do card
function getCardColor($coletor) {
    $colors = [
        'Orgânico' => 'marrom',
        'Papel' => 'azul',
        'Metal' => 'amarelo',
        'Vidro' => 'verde',
        'Plastico' => 'vermelho'
    ];
    return $colors[$coletor] ?? 'default'; // Default para casos não mapeados
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Resíduos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <!-- Formulário de pesquisa -->
    <form action="" method="post">
        <input type="text" name="search" placeholder="Pesquisar..." required>
        <select name="type" id="type">
            <option value="nome" selected>Nome</option>
            <option value="coletor">Coletor</option>
            <option value="descricao">Descrição</option>
        </select>
        <input type="submit" value="Pesquisar">
    </form>

    <!-- Exibe os resíduos como cartões -->
    <?php
    foreach ($residuos as $residuo) {
        $colorClass = getCardColor($residuo->getColetor());
        echo "<div class='card $colorClass'>";
        if ($residuo->getFoto() !== null) {
            echo "<img src='data:image/jpeg;base64," . base64_encode($residuo->getFoto()) . "' alt='Imagem do Resíduo' class='card-image'>";
        } else {
            echo "<td>Sem Foto</td>";
        }
        echo "<div class='card-content'>";
        echo "<p>{$residuo->getNome()}</p>";
        echo "<p>Coletor: {$residuo->getColetor()}</p>";
        echo "<p>{$residuo->getDescricao()}</p>";
        echo "<a href='index.php'><button type='button'>Ver resíduo completo</button></a>";
        echo "</div>";
        echo "<div class='actions'>
                <a href='formEdit.php?idResiduo={$residuo->getIdResiduo()}'><img src='http://localhost/trabalhoEquipe3/Imagens/1159633.png' width='25px'></a>
                <a href='excluir.php?idResiduo={$residuo->getIdResiduo()}'><img src='http://localhost/trabalhoEquipe3/Imagens/126468.png' width='25px'></a> 
              </div>";
        echo "</div>";
    }
    ?>

</div>

<a href="formCad.php">Adicionar Resíduo</a>

</body>
</html>
