<?php

require_once("../conexao/conexao.php");

if (isset($_POST['tipo_tabela'])) {
    $tabelas = [
        1 => "p4_armas",
        2 => "p4_coletes",
        3 => "p4_tpd",
        4 => "p4_municoes",
        5 => "p4_taser",
        6 => "p4_algemas",
        7 => "p4_ht"
    ];

    $tipoTabela = $_POST['tipo_tabela'];

    if (!isset($tabelas[$tipoTabela])) {
        die("Tabela inválida!");
    }

    $nomeTabela = $tabelas[$tipoTabela];

    // Buscar os modelos automaticamente pela categoria
    $sqlModelos = "SELECT idModelo, modelo FROM p4_modelos WHERE categoria = :categoria";
    $stmtModelos = $conexao->prepare($sqlModelos);
    $stmtModelos->bindParam(':categoria', $tipoTabela, PDO::PARAM_INT);
    $stmtModelos->execute();
    $modelos = $stmtModelos->fetchAll(PDO::FETCH_ASSOC);

    $sqlTamanhos = "SELECT idTamanhos, descricao FROM p4_tamanhos";
    $stmtTamanhos = $conexao->prepare($sqlTamanhos);
    $stmtTamanhos->execute();
    $tamanhos = $stmtTamanhos->fetchAll(PDO::FETCH_ASSOC);

    $sqlStatus = "SELECT idStatus, estado FROM p4_status";
    $stmtStatus = $conexao->prepare($sqlStatus);
    $stmtStatus->execute();
    $statusList = $stmtStatus->fetchAll(PDO::FETCH_ASSOC);

    // Buscar locais de compra com JOIN para trazer os nomes completos
    $sqlLocComp = "SELECT lc.idLocComp, l.descricaolocal, c.descricaocomplemento 
                   FROM p4_localcomplemento lc
                   JOIN p4_local l ON lc.idlocal = l.idLocal
                   JOIN p4_complemento c ON lc.idcomplemento = c.idComplemento
                   ORDER BY lc.idlocal ASC, lc.idcomplemento ASC";
    $stmtLocComp = $conexao->prepare($sqlLocComp);
    $stmtLocComp->execute();
    $locaisComplementos = $stmtLocComp->fetchAll(PDO::FETCH_ASSOC);

    // Obter os campos da tabela selecionada
    $comandoSQL = "DESCRIBE $nomeTabela";
    $stmt = $conexao->prepare($comandoSQL);
    $stmt->execute();
    $campos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<form method='POST' action='./materialbelicobd.php' enctype='multipart/form-data'>";
    echo "<input type='hidden' name='tipo_tabela' value='" . htmlspecialchars($_POST['tipo_tabela']) . "'>";

    $primeiroCampo = true;
    foreach ($campos as $campo) {
        $nomeCampo = $campo['Field'];

        if ($primeiroCampo) {
            $primeiroCampo = false;
            continue;
        }


        if( $tabelas[$tipoTabela] === "p4_municoes" && $nomeCampo === 'numerodepatrimonio' ){
            echo "<label for='$nomeCampo'>lote</label>";
        }
        else{
        echo "<label for='$nomeCampo'>$nomeCampo</label>";
        }
        if ($nomeCampo === 'idModelo') {
            echo "<select name='$nomeCampo' id='$nomeCampo'>";
            echo "<option value=''>Selecione um modelo</option>";
            foreach ($modelos as $modelo) {
                echo "<option value='{$modelo['idModelo']}'>{$modelo['modelo']}</option>";
            }
            echo "</select><br>";
        } elseif ($nomeCampo === 'id_tamanho') {
            echo "<select name='$nomeCampo' id='$nomeCampo'>";
            echo "<option value=''>Selecione um tamanho</option>";
            foreach ($tamanhos as $tamanho) {
                echo "<option value='{$tamanho['idTamanhos']}'>{$tamanho['descricao']}</option>";
            }
            echo "</select><br>";
        }       elseif ($nomeCampo === 'foto') {
            echo "<label for='foto' style='cursor:pointer; display:flex; align-items:center; gap:10px; font-size:18px;'>
                    <i class='fas fa-camera' style='font-size:40px; color:#555;'></i>
                    <span>Selecione a foto</span>
                  </label>";
            echo "<input type='file' name='foto' id='foto' accept='image/*' onchange='previewImagem(event)' style='display:none;'><br>";
            echo "<img id='preview' src='#' alt='Prévia da Imagem' style='display:none; max-width:200px; margin-top:10px;'><br>";
        
        } elseif ($nomeCampo === 'validade') {
            echo "<input type='date' name='$nomeCampo' id='$nomeCampo'><br>";
        } else {
            echo "<input type='text' name='$nomeCampo' id='$nomeCampo'><br>";
        }
    }

    // Campo idStatus como select
    echo "<label for='idStatus'>estatus</label>";
    echo "<select name='idStatus' id='idStatus' required>";
    echo "<option value=''>Selecione um status</option>";
    foreach ($statusList as $status) {
        echo "<option value='{$status['idStatus']}'>{$status['estado']}</option>";
    }
    echo "</select><br>";

    // Campo de local de compra
    echo "<label for='idLocComp'>Local </label>";
    echo "<select name='idLocComp' id='idLocComp' required>";
    echo "<option value=''>Selecione um local</option>";
    foreach ($locaisComplementos as $local) {
        $valor = $local['idLocComp'];
        $descricao = "{$local['descricaolocal']} - {$local['descricaocomplemento']}";
        echo "<option value='$valor'>$descricao</option>";
    }
    echo "</select><br>";

    echo "<button type='submit'>Salvar</button>";
    echo "</form>";
} else {
    echo "Nenhuma tabela selecionada!";
}
