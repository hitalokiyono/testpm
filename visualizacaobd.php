<?php
require_once("./conexao/conexao.php");

try {
    // Verifica se há algum termo de busca
    $termo = isset($_GET['q']) ? $_GET['q'] : '';

    // Verifica o limite de registros (se não for especificado, o limite será 25)
    $limite = isset($_GET['limit']) ? intval($_GET['limit']) : 25;

    // Prepara a consulta SQL com INNER JOIN e aplica o filtro de busca e limite
    $comandoSQL = "
    SELECT 
        p1.id, 
        p1.NomeCompleto, 
        p1.RE, 
        descricaopermissao.descricao, 
        p1.img, 
        p1.Telefone1,
        permissoes.permissao as  perm
    FROM 
        p1
    INNER JOIN 
        permissoes 
        ON permissoes.id_pm = p1.id
    INNER JOIN 
        descricaopermissao 
        ON descricaopermissao.id_permissao = permissoes.permissao
    WHERE 
        p1.status = 1
        AND (p1.NomeCompleto LIKE :termo OR p1.RE LIKE :termo)
    ORDER BY 
        p1.NomeCompleto ASC
    LIMIT :limite
";

    $stmt = $conexao->prepare($comandoSQL);
    $stmt->bindValue(':termo', '%' . $termo . '%', PDO::PARAM_STR);
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->execute();

    // Pega os dados em formato de matriz
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verifica o total de registros encontrados
    $totalRegistros = count($dados);
    session_start();
    if ($_SESSION["permissao"] > 0) {
        foreach ($dados as $linha) {


            echo "<tr data-img='./{$linha['img']}' data-nome='{$linha['NomeCompleto']}' data-telefone='{$linha['Telefone1']}'>";
            echo "<td align='center'>{$linha['NomeCompleto']}</td>";
            echo "<td>{$linha['RE']}</td>";
            echo "<td>{$linha['descricao']}</td>";
            echo "<td align='center' id='tdimg'><a href='./atualizar.php?id={$linha['id']}'>
              <img id='imgvisu' src='./img/atualizar.png' alt='Atualizar'></a></td>";
            echo "<td align='center' id='tdimg2'><a href='./excluir.php?id={$linha['id']}'>
              <img id='imgvisu' src='./img/excluir.png' alt='Excluir'></a></td>";
            echo "</tr>";
        }
    } else {
        foreach ($dados as $linha) {

            echo "<tr data-img='./{$linha['img']}' data-nome='{$linha['NomeCompleto']}' data-telefone='{$linha['Telefone1']}'>";
            echo "<td align='center'>{$linha['NomeCompleto']}</td>";
            echo "<td>{$linha['RE']}</td>";
            echo "<td>{$linha['descricao']}</td>";
            echo "<td align='center' id='tdimg'><a href='./atualizar.php?id={$linha['id']}'>
              <img id='imgvisu' src='./img/atualizar.png' alt='Atualizar'></a></td>";
            echo "</tr>";
        }
    }
} catch (PDOException $erro) {
    echo "<tr><td colspan='5' align='center'>Erro ao realizar a busca: " . $erro->getMessage() . "</td></tr>";
}
