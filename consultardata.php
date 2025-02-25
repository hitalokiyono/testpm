<?php
require_once("./conexao/conexao.php");
require_once("./menu.php");
if (!isset($_SESSION)) {
    session_start();
}
$reFilter = isset($_GET['re']) ? $_GET['re'] : "";
try {
    // Inicializa a variável $agendamentos para evitar problemas de escopo
    $agendamentos = [];

    // Verifica se o ID atual na sessão é diferente de 5
    if ($_SESSION['permissao'] != 5) {
        $sql = "
            SELECT 
                da.id_dataagendamento, 
                p.NomeCompleto AS nome_pm, 
                p.RE AS re, 
                da.Data, 
                a.nome AS tipo_agendamento, 
                da.entregue, 
                da.recebida
            FROM data_agendamento da
            JOIN p1 p ON da.id_pm = p.id
            JOIN agendamentos a ON da.tipo_agendamento = a.id_agenda
            WHERE da.id_pm = :id_pm
        ";

        // Prepara e executa a consulta
        $stmt = $conexao->prepare($sql);
        $stmt->execute([':id_pm' => $_SESSION['id_atual']]);

        // Obtém os resultados
        $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } else {
        $sql = "
            SELECT 
                da.id_dataagendamento, 
                p.NomeCompleto AS nome_pm, 
                p.RE AS re, 
                da.Data, 
                a.nome AS tipo_agendamento, 
                da.entregue, 
                da.recebida
            FROM data_agendamento da
            JOIN p1 p ON da.id_pm = p.id
            JOIN agendamentos a ON da.tipo_agendamento = a.id_agenda
        ";

        // Verifica se há filtro por RE
        if (!empty($reFilter)) {
            $sql .= " WHERE p.RE LIKE :re";
        }

        // Adiciona ordenação
        $sql .= " ORDER BY da.Data DESC";

        // Prepara a consulta
        $stmt = $conexao->prepare($sql);

        // Bind do filtro por RE, se fornecido
        if (!empty($reFilter)) {
            $stmt->bindValue(':re', "%$reFilter%", PDO::PARAM_STR);
        }

        // Executa a consulta
        $stmt->execute();

        // Obtém os resultados
        $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    // Exibe mensagem de erro
    echo "Erro ao buscar dados: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Data Agendamento</title>
    <link rel="stylesheet" href="./css/inicial.css">
    <style>
        .menu ul {
    margin:0px;
    display: flex;
    height: 70px;
    background-color: black;
    background-image: linear-gradient(to left, red, transparent, white);
    justify-content: end;
    align-items: center;
    list-style-type: none;
}

.menu ul li {
    color:white;
    padding: 15px 20px;
}

.menu ul li:hover {
    background-color: crimson;
    color: white;
}

.menu ul a {
    text-decoration: none;
    color: black;
}
        body {
            color: white;
            background-color: #333;
            overflow-y: scroll;
        }
        table {
            background-color: white;
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            color: black;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .search-container {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 8px;
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Consultar Data de Agendamentos</h1>



    
    <div class="search-container">
        <form method="GET" action="consultardata.php">
            <label for="re">Buscar pelo RE:</label>
            <input type="text" id="re" name="re" value="<?= htmlspecialchars($reFilter) ?>" placeholder="Digite o RE">
            <input type="submit" value="Buscar">
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome do PM</th>
                <th>RE</th>
                <th>Data do Agendamento</th>
                <th>Tipo de Agendamento</th>
                <th>Status</th>
                <th>confirmar envio</th>
                <th>confirmar recebimento</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($agendamentos) > 0): ?>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <tr>
                        <td><?= htmlspecialchars($agendamento['nome_pm']) ?></td>
                        <td><?= htmlspecialchars($agendamento['re']) ?></td>
                        <td><?= htmlspecialchars($agendamento['Data']) ?></td>
                        <td><?= htmlspecialchars($agendamento['tipo_agendamento']) ?></td>
                        <td><?= $agendamento['entregue'] ? "Entregue" : "Pendente" ?></td>
                        <td>
                            <?php if (!$agendamento['entregue']): ?>
                                <span> não entregue</span>
                            <?php else: ?>
                                <span>Entregue</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$agendamento['recebida'] ): ?>
                                <?php if ($_SESSION['permissao'] === 5): ?>
    <form action="alterar_status_agendamento.php" method="POST">
        <input type="hidden" name="id_dataagendamento" value="<?= $agendamento['id_dataagendamento'] ?>">
        <button type="submit">Marcar como recebida</button>
    </form>
<?php else: ?>
    <span>Não entregue</span>
<?php endif; ?>
                           <?php else: ?>
                                <span>Recebida</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhum agendamento encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
