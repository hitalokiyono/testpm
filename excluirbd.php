<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

    require_once("./conexao/conexao.php");

    // Inicia uma transação
    $conexao->beginTransaction();

    try {
        // Atualiza o status do policial para inativo
        $sqlPolicial = "UPDATE p1 SET status = 0 WHERE id = :id";
        $stmtPolicial = $conexao->prepare($sqlPolicial);
        $stmtPolicial->execute(array(":id" => $id));

        // Confirma a transação se tudo deu certo
        $conexao->commit();

        // Redireciona após sucesso
        header("location:./visualizacao.php");
        exit();
    } catch (PDOException $erro) {
        // Se houver erro, desfaz a transação
        $conexao->rollBack();
        echo "Erro ao atualizar o status: " . $erro->getMessage();
    }
}
