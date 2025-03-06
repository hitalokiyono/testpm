<?php
require_once("../conexao/conexao.php");

try {
    $comandoSQL = "



    ";

    $stmt = $conexao->prepare($comandoSQL);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalRegistros = count($dados);
} catch (PDOException $erro) {





}
