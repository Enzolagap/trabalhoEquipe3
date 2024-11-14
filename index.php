<?php
require_once __DIR__."/vendor/autoload.php";
$residuos = Residuo::findall();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Residuos</title>
</head>
<body>

<table>
    
    <form action="" method="post">
        <input type="text" name="search" placeholder="Search">
        <select name="type" id="type">
            <option value="nome" selected>Nome</option>
            <option value="coletor">Coletor</option>
            <option value="descricao">Descrição</option>
        </select></select>
        <input type="submit" value="Search">
    </form>

<tr>
        <td>Nome</td>
        <td>Coletor</td>
        <td>Descricao</td>
        <td>Opções</td>
    </tr>
    <?php
    foreach($residuos as $residuo){
        echo "<tr>";
        echo "<td>{$residuo->getNome()}</td>";
        echo "<td>{$residuo->getColetor()}</td>";
        echo "<td>{$residuo->getDescricao()}</td>";
        echo "<td>
                <a href='formEdit.php?idResiduo={$residuo->getIdResiduo()}'><img src='https://e7.pngegg.com/pngimages/438/470/png-clipart-drawing-pencil-landscape-painting-pencil-angle-pencil.png' width='30px'></a>
                <a href='excluir.php?idResiduo={$residuo->getIdResiduo()}'><img src='https://e7.pngegg.com/pngimages/891/702/png-clipart-rubbish-bins-waste-paper-baskets-computer-icons-recycling-bin-icon-free-trash-can-text-rectangle.png' width='30px'></a> 
             </td>";
       
        echo "</tr>";
    }
    ?>
</table>
<a href='formCad.php'>Adicionar Residuo</a>
</body>
</html>