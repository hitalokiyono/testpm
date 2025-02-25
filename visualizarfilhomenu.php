<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Inicial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/estilo.css">
    <?php
                require_once("./menu.php");
                ?>

    <link rel="stylesheet" href="./css/inicial.css">
</head>
<h1 class="titulo">Controlhe de filhos cadastrado</h1>
<body>
    <div class="menuicon">
        <div class="img"></div>
        <ul>
            <li><a href="./visualizarfilho.php"><i class="fas fa-clipboard-list"></i> Visualizar</a></li>
            <li><a href="./cadastrofilho.php"><i class="fas fa-clipboard-list"></i> Cadastrar</a></li>
            <li><a href="./inicial.php"><i class="fas fa-sign-out-alt"></i> voltar</a></li>
        </ul>
    </div>
</body>

</html>