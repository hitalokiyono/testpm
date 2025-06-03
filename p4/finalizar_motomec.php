<?php
header('Content-Type: application/json');
require_once("../conexao/conexao.php");

try {
    // Receber os dados do JSON
    $input = file_get_contents('php://input');
    $dados = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("erro" . json_last_error_msg());
    }

    if (!isset($dados['idLocacao'], $dados['id_viatura'])) {
        throw new Exception("Parâmetros obrigatórios não fornecidos");
    }

    $idLocacao = $dados['idLocacao'];
    $idViatura = $dados['id_viatura'];

    // Iniciar transação
    $conexao->beginTransaction();

    // 1. Atualizar status da viatura para disponível (2)
    $stmtViatura = $conexao->prepare("
        UPDATE `p4_inventario` 
        SET `idStatus` = '2' 
        WHERE `id` = :id_viatura
    ");
    $stmtViatura->bindParam(':id_viatura', $idViatura, PDO::PARAM_INT);
    $stmtViatura->execute();

    // 2. Atualizar data de fim na locação
    $stmtLocacao = $conexao->prepare("
        UPDATE `locacao_viatura` 
        SET `datafim` = NOW() 
        WHERE `id_locacao` = :id_locacao
    ");
    $stmtLocacao->bindParam(':id_locacao', $idLocacao, PDO::PARAM_INT);
    $stmtLocacao->execute();

    // 3. Atualizar status dos materiais associados para disponível (2)
    $stmtMateriais = $conexao->prepare("
        UPDATE p4_inventario AS inv
        INNER JOIN p4_controleinventario AS con ON inv.id = con.idInventario
        INNER JOIN materias_viaturas AS mv ON con.id_controle = mv.id_controleinventario
        SET inv.idStatus = 2
        WHERE mv.id_alocacao = :id_locacao
    ");
    $stmtMateriais->bindParam(':id_locacao', $idLocacao, PDO::PARAM_INT);
    $stmtMateriais->execute();

    // 4. Atualizar data de saída dos materiais no controle de inventário
    $stmtControle = $conexao->prepare("
        UPDATE p4_controleinventario AS con
        INNER JOIN materias_viaturas AS mv ON con.id_controle = mv.id_controleinventario
        SET con.dtSaida = CURRENT_DATE()
        WHERE mv.id_alocacao = :id_locacao
    ");
    $stmtControle->bindParam(':id_locacao', $idLocacao, PDO::PARAM_INT);
    $stmtControle->execute();

    // Confirmar todas as alterações
    $conexao->commit();

    echo json_encode([
        'status' => 'sucesso',
        'mensagem' => 'Operação finalizada com sucesso',
        'id_locacao' => $idLocacao,
        'id_viatura' => $idViatura
    ]);

} catch (PDOException $e) {
    $conexao->rollBack();
    http_response_code(500);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro no banco de dados',
        'erro' => $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ]);
}