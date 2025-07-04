<?php
require_once("../conexao/conexao.php");

try {
    $dados = [];
    
    if (isset($_POST['re'])) {
        $re = trim($_POST['re']);
        $comandoSQL = "
        SELECT 
            con.*, 
            inv.id AS inventario_id, 
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
        $re = "%$re%";
        $stmt->bindParam(":re", $re, PDO::PARAM_STR);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    elseif (isset($_POST['inventario_id'])) {
        $con = trim($_POST['id_controle']);
        $att = trim($_POST['inventario_id']);

        // Atualiza dtSaida
        $comando = "UPDATE p4_controleinventario SET dtSaida = NOW() WHERE id_controle = :con";
        $stmt = $conexao->prepare($comando);
        $stmt->bindParam(":con", $con, PDO::PARAM_INT);
        $stmt->execute();

        // Atualiza status para 4 (fora)
        $comandoSQL = "UPDATE p4_inventario SET idStatus = 4 WHERE id = :att";
        $stmt = $conexao->prepare($comandoSQL);
        $stmt->bindParam(":att", $att, PDO::PARAM_INT);
        $stmt->execute();

        exit();
    }
        
    elseif (isset($_POST['inventario_id2'])) {
  
        $idinventario = $_POST["inventario_id2"];
        
            $updateSQL = "
                UPDATE p4_controleinventario
                SET dtSaida = NOW()
                WHERE idInventario = :idinventario
                AND dtSaida IS NULL
                ORDER BY dtEntrada DESC
                LIMIT 1
            ";
            $stmt = $conexao->prepare($updateSQL);
            $stmt->bindParam(':idinventario', $idinventario, PDO::PARAM_INT);
            $stmt->execute();

            $att = $idinventario;
            $comandoSQL = "
            UPDATE p4_inventario SET idStatus = 2 WHERE p4_inventario.id = :att;               
            ";
            $stmt = $conexao->prepare($comandoSQL);
            $att = "$att"; // Permite buscar por parte do RE
            $stmt->bindParam(":att", $att, PDO::PARAM_STR);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    exit();}
    else {
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
            tam.*,
            locc.*
        FROM p4_controleinventario AS con
        INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
        INNER JOIN p4_status AS sta ON sta.idStatus = inv.idStatus
        INNER JOIN p1 ON p1.id = con.idPm
        INNER JOIN p4_romaneio AS c ON c.numerodepatrimonio = inv.numerodepatrimonio
        INNER JOIN p4_tamanhos AS tam ON tam.idTamanhos = c.id_tamanho
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
            if ($row['estado'] === 'fora') {
                continue; // Pula o item fora
            }

            echo "<tr>
                    <td class='hidden'>{$row['id']}</td>
                    <td>{$row['nomecompleto']}</td>
                    <td>{$row['RE']}</td>
                    <td>{$row['nomeitem']}</td>
                    <td>{$row['numerodepatrimonio']}</td>
                    <td>{$row['estado']}</td>
                    <td>";

            if ($row['dtSaida'] === null) {
                echo "em operação";
            } else {
                echo "{$row['dtSaida']}";
            }

            echo "</td><td>";

            if ($row['estado'] == 'Operando' && $row['dtSaida'] == null && $_SESSION["permissao"] == 5) {
            } else {
                echo "-";
            }

            echo "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='8' class='text-center'>Nenhum registro encontrado.</td></tr>";
    }

} catch (\Throwable $th) {
    die("Erro na consulta: " . $th->getMessage());
}
?>
