<?php
require_once("../conexao/conexao.php");

try {
    $dados = [];
    
    if (isset($_POST['re'])) {
        $re = trim($_POST['re']);
        $comandoSQL = "
        SELECT 
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
    elseif (isset($_POST['inventario_id'])) {
  
    
        $con = trim($_POST['id_controle']);

        $att = trim($_POST['inventario_id']);
    
    $comando =" 
        UPDATE `p4_controleinventario` 
        SET `dtSaida` = NOW() 
        WHERE `id_controle` = :con;
        ";
        $stmt = $conexao->prepare($comando);
        $stmt->bindParam(":con", $con, PDO::PARAM_STR);
        $stmt->execute();

        $comandoSQL = "
        UPDATE p4_inventario SET idStatus = 2 WHERE p4_inventario.id = :att;               
        ";
        $stmt = $conexao->prepare($comandoSQL);
        $att = "$att"; // Permite buscar por parte do RE
        $stmt->bindParam(":att", $att, PDO::PARAM_STR);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    exit();
    }    
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
        inner join p4_tamanhos  as tam  on  tam.idTamanhos  =  c.id_tamanho  
        INNER JOIN p4_modelos AS mo ON mo.idModelo = c.idModelo
        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
        INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
        INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo;
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
                    <td>{$row['numerodepatrimonio']}</td>
                    <td>{$row['RE']}</td>
                    <td>{$row['estado']}</td>
                    <td>{$row['dtEntrada']}</td>";
            
            if ($row['dtSaida'] === null) {
                echo "<td>em operação</td>"; // Se não houver data de saída, deixa a célula em branco
            } else {
                echo "<td>{$row['dtSaida']}</td>"; // Exibe a data de saída
            }

            // Exibir os botões apenas se o item não estiver operando
            if ($row['estado'] == 'Operando') {
                echo "<td>
                <button class='btn btn-warning' onclick='darBaixa(" . $row["inventario_id"] . ", " . $row["id_controle"] . ")'>Dar Baixa</button>
              </td>";
        
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

