<?php
session_start();
if (!isset($_SESSION["id_atual"]))
    // header("location:./index.php")
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilo.css">
    <title>Controle Policia Militar :: Cadastro</title>

</head>

<body>
    <?php
if (!isset($_SESSION["id_atual"])) {
    $_SESSION['permissao'] = 0;
    require_once("./menu.php");
} else {

    require_once("./consultapermissao.php");

    if ($_SESSION['permissao'] > 0) {
        require_once("./menu.php");
    }
}
?>
    <style>
        body {
            justify-content: center;
            align-items: center;
        }

        .email {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            margin-left :20%;
            margin-top :5%;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .row {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
<div class="email">
    <h2 >verificar email</h2>
    <form method="POST" action="processa-emails.php">
         <!--
    <div class="row">
        <label for="email1">E-mail Institucional:</label>
        <input type="email" id="email1" name="email1" required maxlength="100">
    </div>
    -->
    <div class="row">
        <label for="email2">E-mail de Recuperação:</label>
        <input type="email" id="email2" name="email2" required maxlength="100">
    </div>

    <button type="submit">Salvar</button>
        </form>
    </div>