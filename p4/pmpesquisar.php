<?php
require_once("../conexao/conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

// Verifica se foi enviado um R.E na requisição
$re = isset($_POST['re']) ? trim($_POST['re']) : "";

if ($_SESSION['permissao'] != 5) {
    // Usuário sem permissão 5 só pode ver seu próprio registro
    $comandoSQL = " 
        SELECT 
            p1.id, 
            p1.NomeCompleto, 
            p1.RE, 
            descricaopermissao.descricao, 
            permissoes.permissao as perm
        FROM 
            p1
        INNER JOIN 
            permissoes 
            ON permissoes.id_pm = p1.id
        INNER JOIN 
            descricaopermissao 
            ON descricaopermissao.id_permissao = permissoes.permissao
        WHERE 
            p1.id = :id_atual
    ";

    $stmt = $conexao->prepare($comandoSQL);
    $stmt->bindValue(":id_atual", $_SESSION["id_atual"], PDO::PARAM_INT);
} else {
    // Usuário com permissão 5 pode buscar normalmente

    if ($re !== "") {
        // Filtra pelo R.E digitado
        $comandoSQL = " 
            SELECT 
                p1.id, 
                p1.NomeCompleto, 
                p1.RE, 
                descricaopermissao.descricao, 
                permissoes.permissao as perm
            FROM 
                p1
            INNER JOIN 
                permissoes 
                ON permissoes.id_pm = p1.id
            INNER JOIN 
                descricaopermissao 
                ON descricaopermissao.id_permissao = permissoes.permissao
            WHERE 
                p1.RE LIKE :re
        ";

        $stmt = $conexao->prepare($comandoSQL);
        $stmt->bindValue(":re", "%$re%", PDO::PARAM_STR);
    } else {
        // Caso nenhum R.E seja informado, trazer todos os registros
        $comandoSQL = " 
            SELECT 
                p1.id, 
                p1.NomeCompleto, 
                p1.RE, 
                descricaopermissao.descricao, 
                permissoes.permissao as perm
            FROM 
                p1
            INNER JOIN 
                permissoes 
                ON permissoes.id_pm = p1.id
            INNER JOIN 
                descricaopermissao 
                ON descricaopermissao.id_permissao = permissoes.permissao
        ";

        $stmt = $conexao->prepare($comandoSQL);
    }
}

// Executa a consulta
$stmt->execute();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verifica se há resultados
if (count($dados) > 0) {
    foreach ($dados as $row) {
        echo "<tr>
            <td class='hidden'>{$row['id']}</td>
            <td>{$row['NomeCompleto']}</td>
            <td>{$row['RE']}</td>
            <td>{$row['descricao']}</td>
            <td class='hidden'>{$row['perm']}</td>
            <td>
                <button class='btn btn-success' onclick='locarpm({$row['id']})'>Locar Item</button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>Nenhum registro encontrado</td></tr>";
}
?>
