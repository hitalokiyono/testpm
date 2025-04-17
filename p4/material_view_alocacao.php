<?php
require_once("../conexao/conexao.php");
if (!isset($_SESSION)) {
    session_start();
}

$re = isset($_POST['re']) ? trim($_POST['re']) : null;

$comandoSQL = "
    SELECT 
        inv.id AS inventario_id, 
        inv.numerodepatrimonio,
        inv.idTipo_tabela,
        mo.modelo,
        tt.tipo,
        sta.estado
    FROM p4_inventario AS inv
    INNER JOIN p4_status AS sta ON sta.idStatus = inv.idStatus
    INNER JOIN p4_tipo_tabelas AS tt ON tt.id_tabela = inv.idTipo_tabela
    LEFT JOIN p4_tpd AS tpd ON tpd.numerodepatrimonio = inv.numerodepatrimonio
    LEFT JOIN p4_taser AS taser ON taser.numerodepatrimonio = inv.numerodepatrimonio
    LEFT JOIN p4_ht AS ht ON ht.numerodepatrimonio = inv.numerodepatrimonio
    LEFT JOIN p4_material AS material ON material.numerodepatrimonio = inv.numerodepatrimonio
    LEFT JOIN p4_viaturas AS viaturas ON viaturas.numerodepatrimonio = inv.numerodepatrimonio
    LEFT JOIN p4_romaneio AS romaneio ON romaneio.numerodepatrimonio = inv.numerodepatrimonio
    LEFT JOIN p4_municoes AS municoes ON municoes.numerodepatrimonio = inv.numerodepatrimonio
    LEFT JOIN p4_coletes AS coletes ON coletes.numerodepatrimonio = inv.numerodepatrimonio
    LEFT JOIN p4_armas AS armas ON armas.numerodepatrimonio = inv.numerodepatrimonio
    LEFT JOIN p4_algemas AS algemas ON algemas.numerodepatrimonio = inv.numerodepatrimonio
    LEFT JOIN p4_modelos AS mo ON mo.idModelo = COALESCE(
        tpd.idModelo, taser.idModelo, ht.idModelo, material.idModelo,
        viaturas.Modelo, romaneio.idModelo, municoes.idModelo,
        coletes.idModelo, armas.idModelo, algemas.idModelo
    )
";
if ($re) {
    $comandoSQL .= " WHERE inv.numerodepatrimonio LIKE :re";
    $stmt = $conexao->prepare($comandoSQL);
    $stmt->bindValue(":re", "%$re%", PDO::PARAM_STR);
} else {
    $stmt = $conexao->prepare($comandoSQL);
}
$stmt->execute();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($dados) > 0) {
    foreach ($dados as $row) {
        echo "<tr>
                <td class='hidden'>{$row['inventario_id']}</td>
                <td>{$row['numerodepatrimonio']}</td>
                <td>{$row['modelo']}</td>
                <td>{$row['estado']}</td>";

        if ($_SESSION["permissao"] == 5 && $row['estado'] == 'Operando') {
            echo "<td>
                    <button class='btn btn-success' onclick='darBaixa({$row['inventario_id']}, 0)'>Dar Baixa</button>
                  </td>";
        } else {
            echo "<td></td>";
        }

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>Nenhum registro encontrado.</td></tr>";
}
?>
