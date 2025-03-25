<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Materiais Bélicos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/inicial.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>


/* Resetando o body para o padrão */
body,html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color:rgb(35, 34, 34); /* Cor padrão do Bootstrap */
    color:rgb(0, 0, 0); /* Cor padrão do texto */
}

/* Estilização do título */
.titulo {
    text-align: center;
    margin-top: 20px;
    font-size: 24px;
    font-weight: bold;
    color:rgb(0, 0, 0); /* Azul Bootstrap */
}

/* Centralizando o seletor de tabelas */
#selecaoTabela {
    display: block;
    width: 50%;
    margin: 20px auto;
    
    font-size: 16px;
    border: 1px solid #ced4da;
    border-radius: 5px;
}

/* Container principal */
#container {
    margin-bottom: 39px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

/* Estilização do formulário */
#formulario {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    width: 50%;
}

/* Títulos dentro do formulário */
#formulario h3 {
    text-align: center;
    color: #343a40;
    margin-bottom: 20px;
}

/* Inputs e selects estilizados */
#formulario input,
#formulario select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ced4da;
    border-radius: 5px;
}

/* Botão de envio */
#formulario button {
    width: 100%;
    padding: 10px;
    background-color: #28a745; /* Verde Bootstrap */
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

#formulario button:hover {
    background-color: #218838;
}

/* Estilização do container da foto */
#foto-container {
    text-align: center;
    margin-top: 20px;
}

/* Espaço fixo para a pré-visualização da imagem */
#preview {
    width: 150px;
    height: 150px;
    border: 2px dashed #007bff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background-color: #f8f9fa;
    margin: 0 auto 10px auto;
}

/* Imagem ajustada dentro do preview */
#preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: none;
}

/* Ícone abaixo do label */
#foto-label {
    display: block;
    text-align: center;
    cursor: pointer;
    font-size: 16px;
    color: #007bff;
}

#foto-label i {
    font-size: 30px;
    margin-top: 5px;
}

    </style>


<body>

<?php require_once("./menu.php"); ?>

<h1 class="titulo">Cadastro de  romaneio</h1>

<div id="container">
    <div id="formulario">
        <h3>Formulário de Cadastro</h3>
        <div id="conteudoFormulario">
            <?php
            require_once("../conexao/conexao.php");

            // Nome da tabela fixa
            $nomeTabela = "p4_romaneio";
            $tipoTabela = 10;
            // Buscar os modelos automaticamente pela categoria
            $sqlModelos = "SELECT idModelo, modelo FROM p4_modelos WHERE categoria = :categoria";
            $stmtModelos = $conexao->prepare($sqlModelos);
            $stmtModelos->bindParam(':categoria', $tipoTabela , PDO::PARAM_INT); // Categoria fixada (ajustar conforme necessário)
            $stmtModelos->execute();
            $modelos = $stmtModelos->fetchAll(PDO::FETCH_ASSOC);

            $sqlTamanhos = "SELECT idTamanhos, descricao_tamanho FROM p4_tamanhos";
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

            // Obter os campos da tabela p4_material
            $comandoSQL = "DESCRIBE $nomeTabela";
            $stmt = $conexao->prepare($comandoSQL);
            $stmt->execute();
            $campos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<form method='POST' action='./materialbelicobd.php' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='tipo_tabela' value='10'>"; // Valor fixo para a tabela p4_material
            $primeiroCampo = true;
            foreach ($campos as $campo) {
                $nomeCampo = $campo['Field'];
            
                if ($primeiroCampo) {
                    $primeiroCampo = false;
                    continue;
                }
            
                echo "<label for='$nomeCampo'>$nomeCampo</label>";
            
                if ($nomeCampo === 'idModelo') {
                    echo "<select name='$nomeCampo' id='$nomeCampo'>";
                    echo "<option value=''>Selecione um modelo</option>";
                    foreach ($modelos as $modelo) {
                        echo "<option value='{$modelo['idModelo']}'>{$modelo['modelo']}</option>";
                    }
                    echo "</select><br>";
                } elseif ($nomeCampo === 'id_tamanho') { // Certifique-se de que 'idMoo' está correto
                    echo "<select name='id_tamanho' id='id_tamanho'>";
                    echo "<option value=''>Selecione um modelo</option>";
                    foreach ($tamanhos as $tamanho) {
                        echo "<option value='{$tamanho['idTamanhos']}'>{$tamanho['descricao_tamanho']}</option>";
                    }
                    echo "</select><br>";
                } else {
                    echo "<input type='text' name='$nomeCampo' id='$nomeCampo'><br>";
                }
            }
            

            // Campo idStatus como select
            echo "<label for='idStatus'>Status</label>";
            echo "<select name='idStatus' id='idStatus' required>";
            echo "<option value=''>Selecione um status</option>";
            foreach ($statusList as $status) {
                echo "<option value='{$status['idStatus']}'>{$status['estado']}</option>";
            }
            echo "</select><br>";

            // Campo de local de compra
            echo "<label for='idLocComp'>Local</label>";
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
            ?>
        </div>
    </div>
</div>


    
</body>
</html>