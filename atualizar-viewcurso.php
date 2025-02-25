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
        select 
p1.id,
 p1.NomeCompleto,
 p1.RE,
 p1cursos.id_curso,
 p1cursos.NomeCurso,
 p1cursos.AnoConclusao
from  p1
inner join p1cursos on p1cursos.id_p1 = p1.id

    ";

    // Verifica a permissão do usuário
    if ($_SESSION['permissao'] == 5) {
        // Se for 5, busca todos os registros
        $comandoSQL .= " WHERE (p1.NomeCompleto LIKE :termo OR p1.RE LIKE :termo)";
    } else {
        // Caso contrário, busca apenas os filhos do usuário logado
        $comandoSQL .= " WHERE p1filhos.id_p1 = :id AND (p1.NomeCompleto LIKE :termo OR p1.RE LIKE :termo)";
    }

    // Adiciona ordenação e limite
    $comandoSQL .= " ORDER BY p1.NomeCompleto ASC LIMIT $limite";

    // Prepara a consulta
    $stmt = $conexao->prepare($comandoSQL);
    $stmt->bindValue(':termo', '%' . $termo . '%', PDO::PARAM_STR);

    // Se a permissão não for 5, passa o ID do usuário
    if ($_SESSION['permissao'] != 5) {
        $stmt->bindValue(':id', $_SESSION["id_atual"], PDO::PARAM_INT);
    }

    // Executa a consulta
    $stmt->execute();

    // Pega os dados em formato de matriz
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
} catch (PDOException $erro) {
    echo "<tr><td colspan='6' align='center'>Erro ao realizar a busca: " . $erro->getMessage() . "</td></tr>";
}
?>
