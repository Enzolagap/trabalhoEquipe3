<?php
if(isset($_GET['idResiduo'])){
    require_once __DIR__."/vendor/autoload.php";
    $residuo = Residuo::find($_GET['idResiduo']);
}
if(isset($_POST['botao'])){
    require_once __DIR__."/vendor/autoload.php";
    $residuo = new Residuo($_POST['descricao'],$_POST['coletor'],$_POST['nome']);
    $residuo->setIdResiduo($_POST['idResiduo']);
    $residuo->save();
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edita Rresiduo</title>
</head>
<body>
    <form action='formEdit.php' method='POST'>
        <?php
            echo "Nome: <input name='nome' value='{$residuo->getNome()}' type='text' required>";
            echo "<br>";
            echo "Descrição: <input name='descricao' value={$residuo->getDescricao()} type='text' required>";
            echo "<br>";
            echo "Coletor: <input name='coletor' value={$residuo->getColetor()} type='text' required>";
            echo "<br>";
            echo "<input name='idResiduo' value={$residuo->getIdResiduo()} type='hidden'>";
        ?>
        <br>
        <input type='submit' name='botao'>
    </form>
</body>
</html>