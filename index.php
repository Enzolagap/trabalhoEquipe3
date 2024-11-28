<?php
require_once __DIR__ . "/vendor/autoload.php";
// Inicia sessão
session_start();
// Verifica se a sessão foi criada
if (!isset($_SESSION['id'])) {
    // Se não foi criada a sessão, redireciona para a página inicial
    header("location: login.php");
}

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

// Filtro por coletor
if (isset($_GET['coletor']) && !empty($_GET['coletor'])) {
    $coletor = $_GET['coletor'];
    $residuos = array_filter($residuos, fn($residuo) => $residuo->getColetor() === $coletor);
}

// Ordena os resíduos com base no nome
if ($order === 'ASC') {
    usort($residuos, fn($a, $b) => strcmp($a->getNome(), $b->getNome()));
} else {
    usort($residuos, fn($a, $b) => strcmp($b->getNome(), $a->getNome()));
}

// Alterna o tipo de ordenação para o próximo clique
$nextOrder = $order === 'ASC' ? 'DESC' : 'ASC';
$nextOrderText = $order === 'ASC' ? 'Z a A' : 'A a Z'; // Alterna o texto do link de ordenação

// Função para obter a cor do card
function getCardColor($coletor)
{
    $colors = [
        'Orgânico' => 'marrom',
        'Papel' => 'azul',
        'Metal' => 'amarelo',
        'Vidro' => 'verde',
        'Plástico' => 'vermelho',

    ];
    return $colors[$coletor];
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
    <script src="script.js"></script>
</head>

<body>

    <!-- Container para exibir o cabeçalho -->
    <div class="container-header">
        <div class="logo">
            <img src='http://localhost/trabalhoEquipe3-main/Imagens/Logo.png' width='300px'>
        </div>

        <div class="access-control">
            <a href='logout.php'>Sair</a>
            <h2>Olá, Conteudista.</h2>
        </div>
    </div>

    <!-- Container para exibir os filtros -->
    <div class="container-nav">

        <h1>Resíduos</h1>

        <div class="container-filters"> 
            <!-- Exibe o link de limpar apenas se o filtro de coletor estiver ativo -->
            <?php if (isset($_GET['coletor']) && !empty($_GET['coletor'])): ?>
                <a href="index.php" class="clear-coletor">Limpar Filtro</a>
            <?php endif; ?>

            <!-- Filtro por Coletor -->
            <div class="order-coletor">
                <div class="select-container">
                    <select onchange="window.location.href='?coletor=' + this.value + '&order=<?= $order ?>'">
                        <option value="" selected disabled>Filtrar por coletor</option>
                        <option value="Orgânico" <?= isset($_GET['coletor']) && $_GET['coletor'] == 'Orgânico' ? 'selected' : '' ?>>Orgânico</option>
                        <option value="Papel" <?= isset($_GET['coletor']) && $_GET['coletor'] == 'Papel' ? 'selected' : '' ?>>Papel</option>
                        <option value="Metal" <?= isset($_GET['coletor']) && $_GET['coletor'] == 'Metal' ? 'selected' : '' ?>>Metal</option>
                        <option value="Vidro" <?= isset($_GET['coletor']) && $_GET['coletor'] == 'Vidro' ? 'selected' : '' ?>>Vidro</option>
                        <option value="Plástico" <?= isset($_GET['coletor']) && $_GET['coletor'] == 'Plástico' ? 'selected' : '' ?>>Plástico</option>
                    </select>
                    <img src='http://localhost/trabalhoEquipe3-main/Imagens/filtroColetor.png'>
                </div>
            </div>


            <!-- Link para alternar ordenação alfabeticamente -->
            <div class="order-name">
                <a href="?order=<?= $nextOrder; ?>"><img src='http://localhost/trabalhoEquipe3-main/Imagens/filtroAlfa.png'><?= $nextOrderText; ?></a>
            </div>

            <!-- Formulário de pesquisa -->
            <form action="" method="post">
                <input type="text" name="search" placeholder="🔍︎ Pesquisar">
                <button type="submit">Pesquisar</button>
            </form>
        </div>

    </div>


    <!-- Container para exibir os resíduos -->
    <div class="container-cards">

        <div class="card-add">
            <a href='formCad.php' class="cadastrar-link">
                <div class="add-icon">+</div>
                <h2>Cadastrar Resíduo</h2>
            </a>
        </div>

        <!-- Exibe os resíduos como cartões -->
        <?php
        foreach ($residuos as $residuo) {
            $colorClass = getCardColor($residuo->getColetor());
            echo "<div class='card $colorClass'>";
            echo "<img src='data:image/jpeg;base64," . base64_encode($residuo->getFoto()) . "' alt='Imagem do Resíduo' class='card-image'>";
            echo "<div class='card-content'>";
            echo "<p>{$residuo->getNome()}</p>";
            echo "<p>Coletor: {$residuo->getColetor()}</p>";

            $descricao = $residuo->getDescricao();
            if (strlen($descricao) > 30) {
                $descricaoCortada = substr($descricao, 0, 30) . "...";
                echo "<p class='descricao' onclick='toggleDescricao(this, event)' data-full-text='{$descricao}.'>{$descricaoCortada}</p>";
            } else {
                echo "<p>{$descricao}.</p>";
            }

            echo "</div>";
            echo "<div class='actions'>
                <a href='formEdit.php?idResiduo={$residuo->getIdResiduo()}'><img src='http://localhost/trabalhoEquipe3-main/Imagens/Editar.png' width='25px'></a>
                <a href='excluir.php?idResiduo={$residuo->getIdResiduo()}'><img src='http://localhost/trabalhoEquipe3-main/Imagens/Excluir.png' width='25px'></a> 
              </div>";
            echo "</div>";
        }
        ?>

    </div>


</body>

</html>