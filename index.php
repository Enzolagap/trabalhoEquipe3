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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Resíduos</title>
</head>
<body>

<table>
    
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

<tr>
        <td>Nome</td>
        <td>Coletor</td>
        <td>Descrição</td>
        <td>Foto</td>
        <td>Opções</td>
    </tr>
    <?php
    // Corrigido para percorrer o array de resíduos
    foreach ($residuos as $residuo) {
        echo "<tr>";
        echo "<td>{$residuo->getNome()}</td>";
        echo "<td>{$residuo->getColetor()}</td>";
        echo "<td>{$residuo->getDescricao()}</td>";
        
        // Exibe a foto
        if ($residuo->getFoto() !== null) {
            echo "<td><img src='data:image/jpeg;base64," . base64_encode($residuo->getFoto()) . "' width='50' height='50'></td>";
        } else {
            echo "<td>Sem Foto</td>";
        }
        
        echo "<td>
                <a href='formEdit.php?idResiduo={$residuo->getIdResiduo()}'><img src='https://e7.pngegg.com/pngimages/438/470/png-clipart-drawing-pencil-landscape-painting-pencil-angle-pencil.png' width='30px'></a>
                <a href='excluir.php?idResiduo={$residuo->getIdResiduo()}'><img src='https://e7.pngegg.com/pngimages/891/702/png-clipart-rubbish-bins-waste-paper-baskets-computer-icons-recycling-bin-icon-free-trash-can-text-rectangle.png' width='30px'></a> 
             </td>";
        echo "</tr>";
    }
    ?>
</table>

<a href="formCad.php">Adicionar Resíduo</a>

</body>
</html>
