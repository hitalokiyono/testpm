<?php
require_once("../conexao/conexao.php");

if (!isset($_SESSION)) {
    session_start();
}

// Definir quantos registros serão exibidos por página
$registrosPorPagina = 10;

// Verificar qual página o usuário está acessando (padrão: 1)
$paginaAtual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;

// Calcular o OFFSET para o banco de dados
$offset = ($paginaAtual - 1) * $registrosPorPagina;

$dados = [];

// Se houver pesquisa, aplicar o filtro
if (isset($_POST['re'])) {
    $re = trim($_POST['re']);
    $comandoSQL = "
        SELECT p1.* FROM p1 
        WHERE p1.RE LIKE :re
        LIMIT :limit OFFSET :offset
    ";
    $stmt = $conexao->prepare($comandoSQL);
    $re = "%$re%"; // Permite buscar por parte do RE
    $stmt->bindParam(":re", $re, PDO::PARAM_STR);
} else {
    // Consulta sem filtro
    $comandoSQL = "
        SELECT p1.* FROM p1
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $conexao->prepare($comandoSQL);
}

// Adicionar os parâmetros de limite e offset
$stmt->bindParam(":limit", $registrosPorPagina, PDO::PARAM_INT);
$stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
$stmt->execute();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar o número total de registros para calcular a paginação
$totalRegistrosSQL = "SELECT COUNT(*) FROM p1";
if (isset($_POST['re'])) {
    $totalRegistrosSQL .= " WHERE p1.RE LIKE :re";
}

$totalStmt = $conexao->prepare($totalRegistrosSQL);
if (isset($_POST['re'])) {
    $totalStmt->bindParam(":re", $re, PDO::PARAM_STR);
}
$totalStmt->execute();
$totalRegistros = $totalStmt->fetchColumn();
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Exibir os registros na tabela
if (count($dados) > 0) {
    foreach ($dados as $row) {
        echo "<tr id='linha-{$row['id']}'>
                <td class='hidden'>{$row['id']}</td>
                <td>{$row['NomeCompleto']}</td>
                <td>{$row['RE']}</td>";

        if ($_SESSION["permissao"] == 5) {
            echo "<td>
        <input type='checkbox' class='selecionarPM' id='check-" . $row['id'] . "' value='" . $row['id'] . "'>
      </td>
                  <td>
                    <button class='btn btn-info marcar-responsavel' onclick='marcarResponsavel({$row['id']})'>Marcar</button>
                  </td>";
        }

        echo "</tr>";
    }

    // Exibir paginação
    if ($totalRegistros > $registrosPorPagina) {
        echo "<tr><td colspan='5' class='text-center'>";
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPaginas; $i++) {
            $active = ($i == $paginaAtual) ? "btn-primary" : "btn-outline-primary";
            echo "<button class='btn $active' onclick='carregarPagina($i)'>$i</button> ";
        }
        echo "</div>";
        echo "</td></tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>Nenhum registro encontrado.</td></tr>";
}
?>
