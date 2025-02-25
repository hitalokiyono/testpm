<?php
$dns = "mysql:host=localhost;dbname=2bpmi1cia;charset=utf8mb4";
$user = "root";
$pass = "";

try {

    $conexao = new PDO($dns, $user, $pass);
    // echo "Conectado com sucesso!";
    // exit();

} catch (PDOException $erro) {
    //echo $erro->getMessage();
    echo "Entre em contato com o desenvolvedor";
}
