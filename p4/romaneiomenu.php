

<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["id_atual"])) {
    echo "Usuário não autenticado.";
    exit;
}
else if($_SESSION["permissao"] < 4){
    header("location:../inicial.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Inicial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <?php
                require_once("./menu.php");
                ?>

    <link rel="stylesheet" href="../css/inicial.css">
</head>
<h1 class="titulo">Alocação</h1>
<body>

<div class="menuicon">
<ul>
    <li>
        <a href="./romaneio.php"><i class="fas fa-truck-loading"></i> Romaneio PM</a>
    </li>
    <li>
        <a href="./alocar.php"><i class="fas fa-cogs"></i> Alocar Item</a>
    </li>
    <li>
        <a href="./consultar.php"><i class="fas fa-search"></i> Consultar Item PM</a>
    </li>
    <li>
        <a href="../inicial.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
    </li>
</ul>

</div>
</body>

</html>

