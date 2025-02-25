<?php
require_once("./conexao/conexao.php");
if (!isset($_SESSION)) {
    session_start();
}
try 
{
    if ($_SESSION['permissao'] === 5) {
        
    } else {
        $id =  $_SESSION["id_atual"];
    }
    $sql = "SELECT * FROM p1 WHERE id=:id";
    $comandoSQL = $conexao->prepare($sql);
    $comandoSQL->execute(array(":id" => $id));
    $resultado = $comandoSQL->fetch();
    $img = !empty($resultado['img']) ? $resultado['img'] : "./img/usuario.png";
} catch (PDOException $erro) {
    echo ("Entre em contato com o suporte!");
}