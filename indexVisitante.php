<?php
require_once __DIR__ . "/vendor/autoload.php";

// Verifica se há uma pesquisa sendo feita
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
    
    // Filtra os resíduos com base no nome
    $residuos = Residuo::findnome($searchTerm);

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
<html lang="pt-br">
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

    <a href='login.php'><button type='button'>Entrar</button></a>
    <a href='formCriarUsuario.php'><button type='button'>Criar conta</button></a>

</div>


<!-- Container para exibir os filtros -->
<div class="container-nav">

    <h1>Resíduos</h1>

    <div class="container-filters">
        <!-- Link para alternar ordenação por coletor -->
        <div class="order-coletor">
            <div class="select-container">
                <select id="collector-select" name="collector">
                    <option value="default" disabled selected>Filtrar por Coletor</option>
                    <option value="Organico">Orgânico</option>
                    <option value="Papel">Papel</option>
                    <option value="Metal">Metal</option>
                    <option value="Vidro">Vidro</option>
                    <option value="Plastico">Plástico</option>
                </select>
                <img src='http://localhost/trabalhoEquipe3-main/Imagens/filtroColetor.png'>
            </div>
        </div>


        <!-- Link para alternar ordenação alfabeticamente -->
        <div class="order-name">
            <img src='http://localhost/trabalhoEquipe3-main/Imagens/filtroAlfa.png'>
            <a href="?order=<?= $nextOrder; ?>">A a Z</a>
        </div>
        
        <!-- Formulário de pesquisa -->
        <form action="" method="post">
        <input type="text" name="search" placeholder="🔍︎ Pesquisar" >
        <button type="submit">Pesquisar</button>
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
     
        echo "</div>";
    }
    ?>

</div>

<footer>

    <a href="login.php" onclick="alert('Você precisa efetuar o login para adicionar um resíduo!'); return true;">Adicionar resíduo</a>

</footer>

</body>
</html>
