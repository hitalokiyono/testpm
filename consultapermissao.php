<?php
require_once("./conexao/conexao.php");

// Verifica a permissão do usuário para redirecionamento
$Id_Atual = $_SESSION["id_atual"];
if (isset($Id_Atual)) {
    $verificaPermissao = $conexao->prepare("SELECT permissao FROM permissoes WHERE id_pm = :id_atual");
    $verificaPermissao->execute(array(":id_atual" => $Id_Atual));
    $permissao = $verificaPermissao->fetch(PDO::FETCH_ASSOC);
    $_SESSION['permissao'] = $permissao['permissao'];
}
