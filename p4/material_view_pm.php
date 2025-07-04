<?php
require_once("../conexao/conexao.php");
if (!isset($_SESSION)) {
    session_start();
}

try {
    if($_SESSION['permissao'] < '5' ){
      $re = $_SESSION['RE'];
 }else{    $re = 0;}
    $dados = [];
    
    if (isset($_POST['re'])) {
        $re = trim($_POST['re']);
        $comandoSQL = "
        SELECT 
           inv.id AS inventario_id, 
            con.*, 
            inv.*, 
            p1.*, 
            sta.estado,
            c.*, 
            mo.*, 
            lo.*, 
            ma.*, 
            ti.*, 
            loc.*, 
            locc.*
        FROM p4_controleinventario AS con
        INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
        INNER JOIN p4_status AS sta ON sta.idStatus = inv.idStatus
        INNER JOIN p1 ON p1.id = con.idPm
        INNER JOIN p4_romaneio AS c ON c.numerodepatrimonio = inv.numerodepatrimonio
        INNER JOIN p4_modelos AS mo ON mo.idModelo = c.idModelo
        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
        INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
        INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo
        WHERE p1.RE LIKE :re
        ";
        $stmt = $conexao->prepare($comandoSQL);
        $re = "%$re%"; // Permite buscar por parte do RE
        $stmt->bindParam(":re", $re, PDO::PARAM_STR);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   
    else if($re !=  0  ) {
        $comandoSQL = "
      SELECT 
    inv.id AS inventario_id, 
    con.*, 
    inv.*, 
    p1.*, 
    sta.estado,
    c.*, 
    mo.*, 
    lo.*, 
    ma.*, 
    ti.*, 
    loc.*, 
    locc.*
FROM p4_controleinventario AS con
-- Junta apenas o registro mais recente de cada item
INNER JOIN (
    SELECT idInventario, MAX(dtEntrada) AS dtEntrada
    FROM p4_controleinventario
    GROUP BY idInventario
) AS ult ON ult.idInventario = con.idInventario AND ult.dtEntrada = con.dtEntrada
INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
INNER JOIN p4_status AS sta ON sta.idStatus = inv.idStatus
INNER JOIN p1 ON p1.id = con.idPm
INNER JOIN p4_romaneio AS c ON c.numerodepatrimonio = inv.numerodepatrimonio
INNER JOIN p4_modelos AS mo ON mo.idModelo = c.idModelo
INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo
WHERE p1.RE LIKE :re;

        ";
        $stmt = $conexao->prepare($comandoSQL);
        $re = "%$re%"; // Permite buscar por parte do RE
        $stmt->bindParam(":re", $re, PDO::PARAM_STR);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else{

   $comandoSQL = "
       SELECT 
    inv.id AS inventario_id, 
    con.*, 
    inv.*, 
    p1.*, 
    sta.estado,
    c.*, 
    mo.*, 
    lo.*, 
    ma.*, 
    ti.*, 
    loc.*, 
    locc.*
FROM p4_controleinventario AS con
-- Junta apenas o registro mais recente de cada item
INNER JOIN (
    SELECT idInventario, MAX(dtEntrada) AS dtEntrada
    FROM p4_controleinventario
    GROUP BY idInventario
) AS ult ON ult.idInventario = con.idInventario AND ult.dtEntrada = con.dtEntrada
INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
INNER JOIN p4_status AS sta ON sta.idStatus = inv.idStatus
INNER JOIN p1 ON p1.id = con.idPm
INNER JOIN p4_romaneio AS c ON c.numerodepatrimonio = inv.numerodepatrimonio
INNER JOIN p4_modelos AS mo ON mo.idModelo = c.idModelo
INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo
        ";
        $stmt = $conexao->prepare($comandoSQL);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    if (count($dados) > 0) {
        foreach ($dados as $row) {
          
            if ($row['estado'] === 'Descarga' ||$row['estado'] === 'fora') {
                continue; // Pula a iteração e não exibe este item
            }
          
            echo "<tr>
                    <td class='hidden'>{$row['id']}</td>
                      <td>{$row['NomeCompleto']}</td>
                        <td>{$row['RE']}</td>
                         <td>{$row['modelo']}</td>
                    <td>{$row['numerodepatrimonio']}</td>
                    <td>{$row['estado']}</td>
                    <td>{$row['dtEntrada']}</td>";
            if ($row['dtSaida'] === null) {
                echo "<td>em operação</td>"; // Se não houver data de saída, deixa a célula em branco
            } else {
                echo "<td>{$row['dtSaida']}</td>"; // Exibe a data de saída
            }

          
              if ($row['estado'] !== 'fora' &&  $_SESSION["permissao"] >4  ) {
                echo "<td>   <button class='btn btn-warning' onclick='darBaixa(" . $row["inventario_id"] . ", " . $row["id_controle"] . ")'>Dar Baixa</button>     </td>";
            } else {
                echo "<td></td>";
            } 
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7' class='text-center'>Nenhum registro encontrado.</td></tr>"; // Corrigido para 7 colunas
    }
    
} catch (\Throwable $th) {
    die("Erro na consulta: " . $th->getMessage());
}
?>

