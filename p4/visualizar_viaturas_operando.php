<?php require_once("./menu.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viaturas em Operação</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<style>
        body, html {
          overflow-x: auto;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: rgb(16, 15, 15);
        color: rgb(0, 0, 0);
    }

    /* Estilização do título */
    .titulo {
        text-align: center;
        margin-top: 20px;
        font-size: 24px;
        font-weight: bold;
        color: rgb(0, 0, 0);
    }
    
    .table {
  
        margin-left: 60px;
    }
    
    .container {
        
        margin-bottom: 200px;
    }

    .table-container {
        overflow-y: auto;
    }

    .table tbody {
       
    }

    .table th, .table td {
        white-space: nowrap;
        text-align: center;
    }

    /* Customização adicional para a tabela */
    .table th, .table td {
        vertical-align: middle;
    }
    
    .table-striped tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }
    
    .table th {
        text-align: center;
        background-color: #343a40;
        color: #fff;
    }
    
    .table td {
        text-align: center;
    }
    
    .btn-sm {
        padding: 5px 10px;
    }

    .pesquisar {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .pesquisar input {
        width: 100%;
        max-width: 300px;
        display: inline-block;
    }

    .pesquisar button {
        margin-left: 10px;
        padding: 10px 20px;
        background-color: #007bff;
        border: none;
        color: #fff;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .pesquisar button:hover {
        background-color: #0056b3;
    }

    .pesquisar button:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(38, 143, 255, 0.5);
    }
    
    body, html {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: rgb(63, 62, 62);
        color: rgb(62, 60, 60);
    }
    
    .container {
        height: auto;
    }
    
    /* Estilo para dados ocultos */
    .hidden-data {
        display: none;
    }
    .table tr{

max-height : 100px;

    }
    /* Seus estilos existentes... */
    .filtro-container {
        background: #f8f9fa;
        padding: 5px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        max-height: 300px;
            max-width: 350px;
        align-items: flex-end;
    }
    .filtro-item {
        flex: 1;
    }
    .filtro-item label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    .btn-filtrar {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-filtrar:hover {
        background-color: #0056b3;
    }
    @media (max-width: 1300px) {
    .table th, .table td {
        padding: 0.2rem 0.3rem;
        font-size: 0.75rem;
    }
    
    .btn-sm {
        padding: 0.2rem 0.3rem;
        font-size: 0.7rem;
    }
}
    /* Mantenha seus outros estilos existentes... */
</style>

<h1 class="titulo text-center mt-4 mb-4">Viaturas em Operação</h1>

<?php
require_once("../conexao/conexao.php");

// Obter parâmetros de filtro
$dataFiltro = $_GET['data'] ?? '';
$statusFiltro = $_GET['status'] ?? 'todos'; // 'operacao', 'finalizadas' ou 'todos'

$sql = "SELECT lv.id_locacao, lv.datainicio, lv.datafim,
        GROUP_CONCAT(DISTINCT setr.setor) AS setores,
        vi.placa, vi.prefixo,
        inv.id,
        f.funcao,
        p1.RE, p1.NomeCompleto,
        tab.tipo 
FROM locacao_viatura AS lv 
INNER JOIN p4_inventario AS inv ON lv.id_viatura = inv.id 
INNER JOIN p4_tipo_tabelas as tab on tab.id_tabela = inv.idTipo_tabela  
INNER JOIN p4_viaturas AS vi ON inv.numerodepatrimonio = vi.numerodepatrimonio 
INNER JOIN p4_funcao AS f ON lv.id_funcao = f.id_funcao 
LEFT JOIN locacao_setor as setr on setr.id_locacao = lv.id_locacao 
INNER JOIN p1 ON lv.id_p1responsavel = p1.id";

// Aplicar filtros
$where = [];
$params = [];

if ($statusFiltro === 'operacao') {
    $where[] = "lv.datafim IS NULL";
    if (!empty($dataFiltro)) {
        $where[] = "DATE(lv.datainicio) = :dataFiltro";
        $params[':dataFiltro'] = $dataFiltro;
    }
} elseif ($statusFiltro === 'finalizadas') {
    $where[] = "lv.datafim IS NOT NULL";
    if (!empty($dataFiltro)) {
        $where[] = "DATE(lv.datafim) = :dataFiltro";
        $params[':dataFiltro'] = $dataFiltro;
    }
} elseif ($statusFiltro === 'todos' && !empty($dataFiltro)) {
    // Para 'todos', filtramos por data de início ou data de fim
    $where[] = "(DATE(lv.datainicio) = :dataFiltro OR (lv.datafim IS NOT NULL AND DATE(lv.datafim) = :dataFiltro))";
    $params[':dataFiltro'] = $dataFiltro;
}

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " GROUP BY lv.id_locacao, lv.datainicio, lv.datafim, vi.placa, vi.prefixo, inv.id, f.funcao, p1.RE, p1.NomeCompleto, tab.tipo";
$sql .= " ORDER BY lv.datainicio DESC";


$stmt = $conexao->prepare($sql);

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->execute();
$viaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container" style="margin-bottom: 100px; margin-left: 1px;">
    <div class="filtro-container">
        <div class="filtro-item">
            <label for="statusFiltro">Status:</label>
            <select id="statusFiltro" class="form-select">
                <option value="todos" <?= $statusFiltro === 'todos' ? 'selected' : '' ?>>Todos</option>
                <option value="operacao" <?= $statusFiltro === 'operacao' ? 'selected' : '' ?>>Em Operação</option>
                <option value="finalizadas" <?= $statusFiltro === 'finalizadas' ? 'selected' : '' ?>>Finalizadas</option>
            </select>
        </div>
        
        <div class="filtro-item">
            <label for="dataFiltro">Data:</label>
            <input type="date" id="dataFiltro" class="form-control" value="<?= $dataFiltro ?>">
        </div>
        
        <div class="filtro-item">
            <label for="buscaViatura">Buscar:</label>
            <input type="text" id="buscaViatura" class="form-control" placeholder="Placa, prefixo ou responsável...">
        </div>
        
        <div class="filtro-item">
            <button type="button" class="btn btn-filtrar" onclick="aplicarFiltros()">
                <i class="fas fa-filter"></i> Filtrar
            </button>
            <button type="button" class="btn btn-secondary ms-2" onclick="limparFiltros()">
                <i class="fas fa-times"></i> Limpar
            </button>
        </div>
           <div class="ms-auto"> <!-- Adiciona margem automática à esquerda para empurrar para a direita -->
        <button type="button" class="btn btn-success" onclick="imprimirRelatorio()">
            <i class="fas fa-print"></i> Imprimir
        </button>
    </div>
    </div>

 <table class="table table-striped table-bordered table-hover table-sm">
       <thead>
        <tr>
            <th>Prefixo</th>
            <th>Placa</th>
            <th>Responsável</th>
            <th>RE</th>
            <th>Função</th>
            <th>Setor</th>
            <th>Data Início</th>
            <th>Data Fim</th>
            <th>Ações</th>
            <!-- Dados ocultos -->
            <th class="d-none">ID Locação</th>
            <th class="d-none">ID tipo</th>
            <th class="d-none">ID Viatura</th>
        </tr>
    </thead>
    <tbody id="tabelaViaturas">
        <?php foreach ($viaturas as $viatura): ?>
            <?php 
                // Garantir que as chaves existam
                $id_locacao = $viatura['id_locacao'] ?? 0;
                $id_viatura = $viatura['id'] ?? 0;
                $id_tipo = $viatura['tipo'] ?? "sem";
            ?>
            <tr>
                <td><?= htmlspecialchars($viatura['prefixo'] ?? '') ?></td>
                <td><?= htmlspecialchars($viatura['placa'] ?? '') ?></td>
                <td><?= htmlspecialchars($viatura['NomeCompleto'] ?? '') ?></td>
                <td><?= htmlspecialchars($viatura['RE'] ?? '') ?></td>
                <td><?= htmlspecialchars($viatura['funcao'] ?? '') ?></td>
                <td><?= htmlspecialchars($viatura['setores'] ?? '') ?></td>
                <td><?= htmlspecialchars($viatura['datainicio'] ?? '') ?></td>
                <td><?= !empty($viatura['datafim']) ? htmlspecialchars($viatura['datafim']) : 'Em operação' ?></td>
                <td>
                    <?php if(empty($viatura['datafim'])): ?>
                        <button class="btn btn-primary btn-sm" onclick="finalizarOperacao(<?= $id_locacao ?>, <?= $id_viatura ?>)">
                            Finalizar
                        </button>
                    <?php endif; ?>
                    <button class="btn btn-info btn-sm" onclick="visualizarDetalhes(<?= $id_locacao ?>, <?= $id_viatura ?>, '<?= htmlspecialchars($id_tipo, ENT_QUOTES) ?>')">
                        Detalhes
                    </button>
                </td>
                <!-- Dados ocultos -->
                <td class="d-none"><?= $id_locacao ?></td>
                <td class="d-none"><?= $id_tipo ?></td>
                <td class="d-none"><?= $id_viatura ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

<script>
function visualizarDetalhes(idLocacao, idviatura, idtipo) {
    window.location.href = "detalhes_operacao.php?idlocacao=" + idLocacao + "&idviatura=" + idviatura + "&tabela=" + idtipo;
}

function aplicarFiltros() {
    const status = document.getElementById('statusFiltro').value;
    const data = document.getElementById('dataFiltro').value;
    
    let url = `visualizar_viaturas_operando.php?status=${status}`;
    
    if (data) {
        url += `&data=${data}`;
    }
    
    window.location.href = url;
}

function limparFiltros() {
    window.location.href = "visualizar_viaturas_operando.php";
}

// Filtro de busca rápida
document.getElementById('buscaViatura').addEventListener('keyup', function() {
    const termo = this.value.toLowerCase();
    const linhas = document.querySelectorAll('#tabelaViaturas tr');
    
    linhas.forEach(linha => {
        const textoLinha = linha.textContent.toLowerCase();
        linha.style.display = textoLinha.includes(termo) ? '' : 'none';
    });
});

function filtrarViaturas() {
    let input = document.getElementById("buscaViatura").value.toLowerCase();
    let linhas = document.querySelectorAll("#tabelaViaturas tr");
    
    linhas.forEach(linha => {
        let textoLinha = linha.textContent.toLowerCase();
        linha.style.display = textoLinha.includes(input) ? "" : "none";
    });
}

function finalizarOperacao(idLocacao, id_viatura) {
    if (!confirm('Tem certeza que deseja finalizar esta operação?')) {
        return;
    }

    console.log(idLocacao, id_viatura);
    const dadosParaEnviar = {
        idLocacao: idLocacao,
        id_viatura: id_viatura   
    };
    
    fetch('finalizar_motomec.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosParaEnviar)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na requisição');
        }
        return response.json();
    })
    .then(data => {
        console.log('Resposta do servidor:', data);
        if (data.status === 'sucesso') {
            alert('Operação finalizada com sucesso!');
            window.location.href = "./visualizar_viaturas_operando.php";
        } else {
            throw new Error(data.mensagem || 'Erro ao finalizar operação');
        }
    })
    .catch(error => {
        console.error('Erro ao enviar dados:', error);
        alert('Erro: ' + error.message);
    });
}

// Filtra ao digitar
document.getElementById("buscaViatura").addEventListener("keyup", filtrarViaturas);

function imprimirRelatorio() {
    // Coletar todos os IDs de locação das linhas visíveis
    const idsLocacao = [];
    const linhas = document.querySelectorAll('#tabelaViaturas tr');
    
    linhas.forEach(linha => {
        // Verificar se a linha está visível
        if (linha.style.display !== 'none') {
            // Pegar o ID da locação (está na 10ª coluna, índice 9)
            const idLocacao = linha.cells[9].textContent;
            if (idLocacao) {
                idsLocacao.push(idLocacao);
            }
        }
    });
    
    if (idsLocacao.length === 0) {
        alert('Nenhuma locação encontrada para imprimir!');
        return;
    }
    
    // Pegar os parâmetros de filtro atuais
    const status = document.getElementById('statusFiltro').value;
    const data = document.getElementById('dataFiltro').value;
    
    // Criar URL para a página de impressão
    let url = `imprimir_locacao.php?ids=${idsLocacao.join(',')}`;
    
    if (status && status !== 'todos') {
        url += `&status=${status}`;
    }
    
    if (data) {
        url += `&data=${data}`;
    }
    
    // Abrir em nova janela para impressão
    window.open(url, '_blank');
}
</script>
</body>
</html>