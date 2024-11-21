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

// Verifica o parâmetro de ordenação
$order = $_GET['order'] ?? 'ASC';

// Valida o valor de ordenação para evitar injeção
if (!in_array($order, ['ASC', 'DESC'])) {
    $order = 'ASC';
}

// Ordena os resíduos com base no nome
if ($order === 'ASC') {
    usort($residuos, fn($a, $b) => strcmp($a->getNome(), $b->getNome()));
} else {
    usort($residuos, fn($a, $b) => strcmp($b->getNome(), $a->getNome()));
}

// Alterna o tipo de ordenação para o próximo clique
$nextOrder = $order === 'ASC' ? 'DESC' : 'ASC';

// Função para obter a cor do card
function getCardColor($coletor) {
    $colors = [
        'Orgânico' => 'marrom',
        'Papel' => 'azul',
        'Metal' => 'amarelo',
        'Vidro' => 'verde',
        'Plastico' => 'vermelho',
        
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

<!-- Container para exibir o cabeçalho -->
<div class="container-header">

</div>


<!-- Container para exibir os filtros -->
<div class="container-nav">

    <h1>Resíduos</h1>
    <a href='formLogin.php'><button type='button'>Entrar</button></a>
    <a href='formCriarUsuario.php'><button type='button'>Criar conta</button></a>

    <div class="container-filters">
        <!-- Link para alternar ordenação -->
        <a href="?order=<?= $nextOrder; ?>">A a Z</a>
        
        <!-- Formulário de pesquisa -->
        <form action="" method="post">
        <input type="text" name="search" placeholder="Pesquisar" >
        <select name="type" id="type">
            <option value="nome" selected>Nome</option>
            <option value="coletor">Coletor</option>
            <option value="descricao">Descrição</option>
        </select>
        <input type="submit" value="Pesquisar">
        </form>
    </div>

</div>


<!-- Container para exibir os resíduos -->
<div class="container-cards">
    
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
        echo "</div>";
        echo "<div class='actions'>
                <a href='formEdit.php?idResiduo={$residuo->getIdResiduo()}'><img src='http://localhost/trabalhoEquipe3-main/Imagens/1159633.png' width='25px'></a>
                <a href='excluir.php?idResiduo={$residuo->getIdResiduo()}'><img src='http://localhost/trabalhoEquipe3-main/Imagens/126468.png' width='25px'></a> 
              </div>";
        echo "</div>";
    }
    ?>

</div>

<footer>

    <a href="formCad.php">Adicionar Resíduo</a>

</footer>

</body>
</html>
