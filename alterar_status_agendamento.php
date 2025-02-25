<?php
require_once("./conexao/conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idDataAgendamento = filter_input(INPUT_POST, 'id_dataagendamento', FILTER_VALIDATE_INT);

    if ($idDataAgendamento) {
        try {
            // Atualiza o status de entregue para 1
            $sql = "UPDATE data_agendamento SET recebida = 1 WHERE id_dataagendamento = :id_dataagendamento";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':id_dataagendamento', $idDataAgendamento, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "<script>alert('Status atualizado com sucesso!'); window.location.href='consultardata.php';</script>";
            } else {
                echo "<script>alert('Falha ao atualizar o status.'); window.history.back();</script>";
            }
        } catch (PDOException $e) {
            echo "Erro ao atualizar status: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('ID inválido!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Requisição inválida.'); window.history.back();</script>";
}
?>
