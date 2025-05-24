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
    /* Mantenha seus outros estilos existentes... */
</style>

<h1 class="titulo text-center mt-4 mb-4">Viaturas em Operação</h1>

<?php
require_once("../conexao/conexao.php");

// Obter parâmetros de filtro
$dataFiltro = $_GET['data'] ?? date('Y-m-d');
$statusFiltro = $_GET['status'] ?? 'operacao'; // 'operacao' ou 'finalizadas'

// Consulta base
$sql = "SELECT lv.id_locacao, lv.datainicio, lv.datafim, lv.id_setor,
               vi.placa, vi.prefixo,
               inv.id,
               f.funcao,
               p1.RE, p1.NomeCompleto,
               tab.tipo
        FROM locacao_viatura AS lv
        INNER JOIN p4_inventario AS inv ON lv.id_viatura = inv.id
        inner join p4_tipo_tabelas as tab on tab.id_tabela = inv.idTipo_tabela 
        INNER JOIN p4_viaturas AS vi ON inv.numerodepatrimonio = vi.numerodepatrimonio
        INNER JOIN p4_funcao AS f ON lv.id_funcao = f.id_funcao
        INNER JOIN p1 ON lv.id_p1responsavel = p1.id";

// Aplicar filtros
if ($statusFiltro === 'operacao') {
    $sql .= " WHERE lv.datafim IS NULL";
} else {
    $sql .= " WHERE DATE(lv.datafim) = :dataFiltro";
}

$sql .= " ORDER BY lv.datainicio DESC";

$stmt = $conexao->prepare($sql);

if ($statusFiltro !== 'operacao') {
    $stmt->bindParam(':dataFiltro', $dataFiltro);
}

$stmt->execute();
$viaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container" style="margin-bottom: 100px; margin-left: 1px;">
    <div class="filtro-container">
        <div class="filtro-item">
            <label for="statusFiltro">Status:</label>
            <select id="statusFiltro" class="form-select" onchange="atualizarFiltros()">
                <option value="operacao" <?= $statusFiltro === 'operacao' ? 'selected' : '' ?>>Em Operação</option>
                <option value="finalizadas" <?= $statusFiltro === 'finalizadas' ? 'selected' : '' ?>>Finalizadas</option>
            </select>
        </div>
        
        <div class="filtro-item" id="dataFiltroContainer" style="<?= $statusFiltro === 'operacao' ? 'display: none;' : '' ?>">
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
        </div>
    </div>

    <table class="table table-striped table-bordered table-hover">
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
                <td><?= htmlspecialchars($viatura['id_setor'] ?? '') ?></td>
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


function atualizarFiltros() {
    const status = document.getElementById('statusFiltro').value;
    const dataContainer = document.getElementById('dataFiltroContainer');
    
    if (status === 'finalizadas') {
        dataContainer.style.display = 'block';
    } else {
        dataContainer.style.display = 'none';
    }
}

function aplicarFiltros() {
    const status = document.getElementById('statusFiltro').value;
    const data = status === 'finalizadas' ? document.getElementById('dataFiltro').value : '';
    const busca = document.getElementById('buscaViatura').value;
    
    let url = `visualizar_viaturas_operando.php?status=${status}`;
    
    if (status === 'finalizadas') {
        url += `&data=${data}`;
    }
    
    window.location.href = url;
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
</script>
</body>
</html>