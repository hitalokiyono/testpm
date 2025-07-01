<?php

require_once("../conexao/conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['tipo_tabela'])) {
        die("Erro: Tipo de tabela não informado.");
    }
    
    $tabelas = [
        1 => "p4_armas",
        2 => "p4_coletes",
        3 => "p4_tpd",
        4 => "p4_municoes",
        5 => "p4_taser",
        6 => "p4_algemas",
        7 => "p4_ht",
        8 => "p4_material",
        9 => "p4_viaturas",
        10 => "p4_romaneio"
    ];

    $tipoTabela = $_POST['tipo_tabela'];

    if (!isset($tabelas[$tipoTabela])) {
        die("Erro: Tabela inválida!");
    }

    $nomeTabela = $tabelas[$tipoTabela];

    try {
        $conexao->beginTransaction();

        // Inserindo primeiro na tabela p4_inventario
        $sqlInventario = "INSERT INTO p4_inventario (numerodepatrimonio, idLocComp, idStatus, idTipo_tabela) 
                          VALUES (:numerodepatrimonio, :idLocComp, :idStatus, :idTipo_tabela)";
        $stmtInventario = $conexao->prepare($sqlInventario);
        $stmtInventario->execute([
            ':numerodepatrimonio' => $_POST['numerodepatrimonio'],
            ':idLocComp' => $_POST['idLocComp'],
            ':idStatus' => $_POST['idStatus'],
            ':idTipo_tabela' => $tipoTabela
        ]);

        // Obtendo os campos da tabela específica
        $sqlDescribe = "DESCRIBE $nomeTabela";
        $stmt = $conexao->prepare($sqlDescribe);
        $stmt->execute();
        $campos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dados = [];
        
        // Criando diretório caso não exista
        $caminhoPasta = "../fotoitens/$nomeTabela";
        if (!is_dir($caminhoPasta)) {
            mkdir($caminhoPasta, 0777, true);
        }

        foreach ($campos as $campo) {
            $nomeCampo = $campo['Field'];

            if ($nomeCampo === 'id') continue; // Ignorar campo ID (auto-incremento)

            if (isset($_FILES[$nomeCampo]) && $_FILES[$nomeCampo]['error'] === UPLOAD_ERR_OK) {
                $extensao = pathinfo($_FILES[$nomeCampo]['name'], PATHINFO_EXTENSION);
                $novoNome = uniqid() . "." . $extensao;
                $caminhoDestino = "$caminhoPasta/$novoNome";

                if (move_uploaded_file($_FILES[$nomeCampo]['tmp_name'], $caminhoDestino)) {
                    $dados[$nomeCampo] = $novoNome; // Salva apenas o nome no banco
                } else {
                    throw new Exception("Erro ao fazer upload do arquivo $nomeCampo.");
                }
            } elseif (isset($_POST[$nomeCampo])) {
                $dados[$nomeCampo] = $_POST[$nomeCampo];
            }
        }

        if (!empty($dados)) {
            $colunas = implode(", ", array_keys($dados));
            $placeholders = implode(", ", array_fill(0, count($dados), "?"));
            $sqlInsert = "INSERT INTO $nomeTabela ($colunas) VALUES ($placeholders)";

            $stmtInsert = $conexao->prepare($sqlInsert);
            $stmtInsert->execute(array_values($dados));
        } else {
            throw new Exception("Nenhum dado enviado.");
        }

        $conexao->commit();
        if ($tipoTabela === "9") {
            header("location:./motomecmenu.php");
        } else {
            header("location:./estoque.php");
        }
    } catch (PDOException $e) {
        $conexao->rollBack();
        
        // Verifica se é um erro de violação de chave estrangeira
        if ($e->getCode() == '23000') {
            // Armazena a mensagem de erro na sessão
            session_start();
            $_SESSION['erro'] = "Erro: Por favor, preencha todos os campos obrigatórios corretamente.";
            
            // Redireciona de volta para a página anterior
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            // Outros tipos de erro
            echo "Erro: " . $e->getMessage();
        }
    } catch (Exception $e) {
        $conexao->rollBack();
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "Requisição inválida.";
}