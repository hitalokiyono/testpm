<?php
require_once("./conexao/conexao.php");

// Inicia a sessão se não estiver iniciada
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    
    try {
        // Primeiro verifica se o email existe
        $comandoVerifica = "SELECT email FROM email WHERE email = :email";
        $stmtVerifica = $conexao->prepare($comandoVerifica);
        $stmtVerifica->bindValue(':email', $email);
        $stmtVerifica->execute();
        
        if ($stmtVerifica->rowCount() > 0) {
            // Se o email existe, atualiza
            $comandoAtualiza = "UPDATE email SET verificado = '1' WHERE email = :email";
            $stmtAtualiza = $conexao->prepare($comandoAtualiza);
            $stmtAtualiza->bindValue(':email', $email);
            $stmtAtualiza->execute();
            
            echo "E-mail $email validado com sucesso!";


              echo "<script>
            alert('Alteração foi realizada com sucesso.');
            window.location.href = './inicial.php';
        </script>";
        } else {
            // Se o email não existe, apenas ignora
            echo "E-mail $email não encontrado na base de dados.";
        }
    } catch (PDOException $e) {
        echo "Erro ao processar a solicitação: " . $e->getMessage();
    }
} else {
    echo "E-mail não fornecido!";
}
?>