<?php
if(isset($_POST['botao'])){
    require_once __DIR__."/vendor/autoload.php";
    $residuo = new Residuo($_POST['descricao'],$_POST['coletor'],$_POST['nome']);
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
    <title>Adiciona Residuo</title>
</head>
<body>
    <form action='formCad.php' method='POST'>
        Nome: <input name='nome' type='text' required>
        <br>
        Descrição: <input name='descricao' type='text' required>
        <br>
        Coletor: <input name='coletor' type='text' required>
        <br>
        <input type ='file' name='arquivo' required>
        <input type='submit' name='botao'>
    </form>
</body>
</html>