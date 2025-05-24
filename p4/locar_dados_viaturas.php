<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once("../conexao/conexao.php");

try {
    $input = file_get_contents('php://input');
    $dados = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Erro ao decodificar JSON: " . json_last_error_msg());
    }

    if (!isset($dados['viatura'], $dados['responsavel'], $dados['funcao'], $dados['setor'], $dados['material'])) {
        throw new Exception("Faltando parâmetros obrigatórios no JSON");
    }

    // Busca o ID do inventário baseado na viatura (usando PDO)
    $stmt_viatura = $conexao->prepare("SELECT p4_inventario.id
                                     FROM p4_inventario 
                                     INNER JOIN p4_viaturas as vi ON p4_inventario.numerodepatrimonio = vi.numerodepatrimonio
                                     WHERE vi.idViaturas = :viatura");
    $stmt_viatura->bindParam(":viatura", $dados['viatura'], PDO::PARAM_INT);
    $stmt_viatura->execute();
    
    $row = $stmt_viatura->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        throw new Exception("Nenhum inventário encontrado para a viatura informada");
    }
    $viatura = $row['id'];

    $responsavel = $dados['responsavel'];
    $passageiros = $dados['passageiros'] ?? [];
    $funcao = $dados['funcao'];
    $material = $dados['material'];
    $setor = $dados['setor'];

    
    $stmt_locacao1 = $conexao->prepare("UPDATE `p4_inventario` SET `idStatus` = '1' WHERE `p4_inventario`.`id` = :viatura");
    $stmt_locacao1->bindParam(":viatura", $viatura, PDO::PARAM_INT);
    $stmt_locacao1->execute();

    if (!is_array($passageiros)) {
        throw new Exception("O campo passageiros deve ser um array");
    }

    // Inicia transação
    $conexao->beginTransaction();










    // Inserção na tabela locacao_viatura
    $stmt_locacao = $conexao->prepare("INSERT INTO `locacao_viatura` 
        (`id_locacao`, `id_viatura`, `id_funcao`, `id_p1responsavel`, `id_setor`, `datainicio`, `datafim`) 
        VALUES (NULL, :viatura, :funcao, :responsavel, :setor, current_timestamp(), NULL)");
    $stmt_locacao->bindParam(":viatura", $viatura, PDO::PARAM_INT);
    $stmt_locacao->bindParam(":funcao", $funcao, PDO::PARAM_INT);
    $stmt_locacao->bindParam(":responsavel", $responsavel, PDO::PARAM_INT);
    $stmt_locacao->bindParam(":setor", $setor, PDO::PARAM_INT);
    $stmt_locacao->execute();

    $id_locacao = $conexao->lastInsertId();

    // Prepara as declarações
    $stmt_update = $conexao->prepare("UPDATE p4_inventario SET idStatus = 1 WHERE id = :material");

    $stmt_controle = $conexao->prepare("INSERT INTO `p4_controleinventario` 
        (`id_controle`, `idPm`, `idInventario`, `dtEntrada`, `dtSaida`) 
        VALUES (NULL, :idpm, :idinventario, current_timestamp(), NULL)");
        
    $stmt_materiais = $conexao->prepare("INSERT INTO `materias_viaturas` 
        (`id_materias_viaturas`, `id_controleinventario`, `id_alocacao`) 
        VALUES (NULL, :id_controle, :id_alocacao)");
    $stmt_passageiros = $conexao->prepare("INSERT INTO `p4_viaturapassageiros` 
        (`id`, `idPassageiro`, `id_locacao_viatura`) 
        VALUES (NULL, :idPassageiro, :id_locacao)");

    // Processa materiais
    foreach ($material as $id_material) {
        if (!is_numeric($id_material)) {
            throw new Exception("ID de material inválido: " . $id_material);
        }
        
        $stmt_update->execute([':material' => $id_material]);
        $stmt_controle->execute([
            ':idpm' => $responsavel,
            ':idinventario' => $id_material
        ]);
        
        $stmt_materiais->execute([
            ':id_controle' => $conexao->lastInsertId(),
            ':id_alocacao' => $id_locacao
        ]);
    }

    // Processa passageiros
    foreach ($passageiros as $id_passageiro) {
        if (!is_numeric($id_passageiro)) {
            throw new Exception("ID de passageiro inválido: " . $id_passageiro);
        }
        
        $stmt_passageiros->execute([
            ':idPassageiro' => $id_passageiro,
            ':id_locacao' => $id_locacao
        ]);
    }

    $conexao->commit();

    echo json_encode([
        'status' => 'sucesso',
        'id_locacao' => $id_locacao,
        'message' => 'Locação realizada com sucesso'
    ]);

} catch (PDOException $e) {
    if(isset($conexao) && $conexao->inTransaction()) {
        $conexao->rollBack();
    }
    
    http_response_code(500);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro no banco de dados',
        'debug' => $e->getMessage()
    ]);
} catch (Exception $e) {
    if(isset($conexao) && $conexao->inTransaction()) {
        $conexao->rollBack();
    }

    http_response_code(400);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage(),
        'dados_recebidos' => $dados ?? null
    ]);
}