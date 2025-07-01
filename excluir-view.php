<?php
require_once("./conexao/conexao.php");

try {
    $sql = "SELECT * FROM p1 WHERE id=:id AND status = 1";
    $comandoSQL = $conexao->prepare($sql);
    $comandoSQL->execute(array(":id" => $id));
    $resultado = $comandoSQL->fetch();
} catch (PDOException $erro) {
    echo ("Entre em contato com o suporte!");
}
