<?php
require_once("./conexao/conexao.php");

try {
    // Inicia a sessão se não estiver iniciada
    if (!isset($_SESSION)) {
        session_start();
    }

    // Verifica se há algum termo de busca
    $termo = isset($_GET['q']) ? $_GET['q'] : '';

    // Verifica o limite de registros (se não for especificado, o limite será 25)
    $limite = isset($_GET['limit']) ? intval($_GET['limit']) : 25;

    // Define a base da consulta SQL
    $comandoSQL = "
        SELECT 
            p1.id,
            p1.NomeCompleto,
            p1.RE,
            p1cursos.id_curso,
            p1cursos.NomeCurso,
            p1cursos.AnoConclusao
        FROM p1
        INNER JOIN p1cursos ON p1cursos.id_p1 = p1.id
    ";

    // Verifica a permissão do usuário
    if ($_SESSION['permissao'] >  1) {
        // Se for 5, busca todos os registros com termo
        $comandoSQL .= " WHERE (p1.NomeCompleto LIKE :termo OR p1.RE LIKE :termo)";
        $stmt = $conexao->prepare($comandoSQL);
        $stmt->bindValue(':termo', '%' . $termo . '%', PDO::PARAM_STR);
    } else {
        // Caso contrário, busca apenas os filhos do usuário logado
        $comandoSQL .= " WHERE p1.id = :id";
        $stmt = $conexao->prepare($comandoSQL);
        $stmt->bindValue(':id', $_SESSION["id_atual"], PDO::PARAM_INT);
    }

    // Adiciona ordenação e limite
    $comandoSQL .= " ORDER BY p1.NomeCompleto ASC LIMIT $limite";

    // Executa a consulta
    $stmt->execute();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verifica o total de registros encontrados
    $totalRegistros = count($dados);

    foreach ($dados as $linha) {
        echo "<tr>";
        echo "<td align='center'>{$linha['NomeCompleto']}</td>";
        echo "<td>{$linha['RE']}</td>";
        echo "<td>{$linha['NomeCurso']}</td>";
        echo "<td>{$linha['AnoConclusao']}</td>";
     
        // Botão de exclusão
        echo "<td align='center'>
        <button class='btn-excluir' data-id='{$linha['id_curso']}' style='border: none; background: none; cursor: pointer;'>
            <img id='imgvisu' src='./img/excluir.png' alt='Excluir'>
        </button>
      </td>";
        echo "</tr>";
    }
    // Restante do seu código...
} catch (PDOException $erro) {
    echo "<tr><td colspan='6' align='center'>Erro ao realizar a busca: " . $erro->getMessage() . "</td></tr>";
}
?>
