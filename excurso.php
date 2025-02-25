<?php
require_once("./conexao/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    

    $idFilho = isset($_POST["id_filho"]) ? intval($_POST["id_filho"]) : 0;

    if ($idFilho <= 0) {
        echo json_encode(["success" => false, "message" => "ID inválido."]);
        exit();
    }

    try {
        $sql = "DELETE FROM p1cursos WHERE id_curso = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $idFilho, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(["success" => true]);
    } catch (PDOException $erro) {
        echo json_encode(["success" => false, "message" => $erro->getMessage()]);
    }
}
?>
