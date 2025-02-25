<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("./conexao/conexao.php");

    // Sanitiza as entradas do usuário
    $usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Formata o RE para o mesmo estilo do banco de dados (444242-3)
    $usuarioFormatado = preg_replace('/\D/', '', $usuario); // Remove tudo que não é número
    $usuarioFormatado = substr($usuarioFormatado, 0, 6) . '-' . substr($usuarioFormatado, 6, 1); // Formata o RE como xxxxxx-x

    // Formata o CPF (senha) para o mesmo estilo do banco de dados
    $senhaFormatada = preg_replace('/\D/', '', $senha); // Remove tudo que não é número
    $senhaFormatada = substr($senhaFormatada, 0, 3) . '.' .
        substr($senhaFormatada, 3, 3) . '.' .
        substr($senhaFormatada, 6, 3) . '-' .
        substr($senhaFormatada, 9, 2); // Formata o CPF como xxx.xxx.xxx-xx

    try {
        // Prepara a consulta para buscar o usuário pelo RE
        $comandoSQL = "SELECT * FROM p1 WHERE RE = :usuario";
        $comandoSQL = $conexao->prepare($comandoSQL);
        $comandoSQL->bindParam(":usuario", $usuarioFormatado); // Usa o RE formatado
        $comandoSQL->execute();

        // Verifica se o usuário existe
        if ($comandoSQL->rowCount() > 0) {
            $dados = $comandoSQL->fetch(PDO::FETCH_ASSOC); // Use PDO::FETCH_ASSOC para obter um array associativo

            // Verifica se a senha formatada (CPF) está correta
            if ($senhaFormatada === $dados["CPF"]) { // A senha é comparada diretamente ao CPF
                session_start();
                // Armazenando informações na sessão
                $_SESSION["id_atual"] = $dados["id"];
                require_once("./consultapermissao.php");
                if ($_SESSION['permissao'] > 0) {

                    header("location:./inicial.php");
                } else {
                    header("location:./inicial.php");
                }
                exit();
            } else {
                // Se a senha estiver incorreta
                header("location:./index.php?status=erro-senha");
                exit();
            }
        } else {
            // Se o usuário não existir
            header("location:./index.php?status=erro-usuario");
            exit();
        }
    } catch (PDOException $erro) {
        // Em caso de erro na execução da consulta
        header("location:./index.php?status=erro-usuario-suporte");
        exit();
    }
} else {
    // Se não for um POST
    header("location:./index.php?status=erro-usuario");
    exit();
}
