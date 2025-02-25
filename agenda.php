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
<h1 class="titulo">Agenda</h1>
<body>


    <div class="menuicon">
        <div class="img"></div>
        <ul>
            <?php
            if (!isset($_SESSION)) {
                session_start();
            }
            if ($_SESSION['permissao'] == 5) {
          
                echo '<li><a href="./novo_agendamento.php"><i class="fas fa-user-plus"></i> CADASTRAR NOVO EVENTO</a></li>';

            } 
            ?>
            <li><a href="./consultardata.php"><i class="fas fa-clipboard-list"></i> CONSULTAR</a></li>
            <li><a href="./inicial.php"><i class="fas fa-sign-out-alt"></i> voltar</a></li>
        </ul>
    </div>
</body>

</html>