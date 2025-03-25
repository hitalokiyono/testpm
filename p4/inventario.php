<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
    /* Resetando o body para o padrão */
body,html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color:rgb(16, 15, 15); /* Cor padrão do Bootstrap */
    color:rgb(0, 0, 0); /* Cor padrão do texto */
}

/* Estilização do título */
.titulo {
    text-align: center;
    margin-top: 20px;
    font-size: 24px;
    font-weight: bold;
    color:rgb(0, 0, 0); /* Azul Bootstrap */
}
.table{
    width: 100%;
    margin-left:60px ;
}
    .container {
    margin-bottom: 200px;}


    .table-container {
  
    overflow-y: auto; /* Adiciona rolagem vertical quando necessário */
}

.table tbody {
    width: 100%;
    overflow-y: auto;
}

.table thead, .table tbody tr {
  
 
}

.table th, .table td {
    white-space: nowrap; /* Impede que o texto quebre */
    text-align: center;
}

</style>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Materiais Bélicos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/inicial.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Customização adicional para a tabela */
        .table th, .table td {
            vertical-align: middle; /* Alinha o conteúdo das células ao centro */
        }
        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9; /* Cor de fundo suave para linhas ímpares */
        }
        .table th {
            text-align: center; /* Centraliza os cabeçalhos */
            background-color: #343a40; /* Cor de fundo escura para cabeçalhos */
            color: #fff; /* Cor do texto no cabeçalho */
        }
        .table td {
            text-align: center; /* Centraliza o texto nas células */
        }
        .btn-sm {
            padding: 5px 10px; /* Botões menores com mais espaçamento */
        }

        .pesquisar {
    background: #f8f9fa; /* Fundo suave */
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.pesquisar input {
    width: 100%;
    max-width: 300px; /* Limita o tamanho do campo */
    display: inline-block;
}

.pesquisar button {
    margin-left: 10px;
    padding: 10px 20px; /* Mais espaçamento dentro do botão */
    background-color: #007bff; /* Cor de fundo azul do Bootstrap */
    border: none;
    color: #fff; /* Texto branco */
    border-radius: 5px; /* Bordas arredondadas */
    font-size: 16px;
    cursor: pointer; /* Aponta que o botão é clicável */
    transition: background-color 0.3s ease; /* Transição suave para mudanças de cor */
}

.pesquisar button:hover {
    background-color: #0056b3; /* Cor mais escura ao passar o mouse */
}

.pesquisar button:focus {
    outline: none; /* Remove a borda padrão do foco */
    box-shadow: 0 0 0 3px rgba(38, 143, 255, 0.5); /* Sombra suave no foco */
}
.tipos {
    margin-top: 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.tipos label {
    background: #343a40; /* Fundo escuro para os rótulos */
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
}

.tipos input[type="checkbox"] {
    transform: scale(1.2);
}

body,html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color:rgb(63, 62, 62); /* Cor padrão do Bootstrap */
    color:rgb(62, 60, 60); /* Cor padrão do texto */
}
.container{
    height: auto;
}
    </style>
</head>

<body>

<?php require_once("./menu.php"); ?>

<h1 class="titulo text-center mt-4 mb-4">Inventário</h1>

<?php
require_once("../conexao/conexao.php");

// Tabelas associadas aos tipos
$tabelas = [
    1 => "p4_armas",
    2 => "p4_coletes",
    3 => "p4_tpd",
    4 => "p4_municoes",
    5 => "p4_taser",
    6 => "p4_algemas",
    7 => "p4_ht",
    8 => "p4_material",
    9 => "p4_viaturas",
    10 => "p4_romaneio",
    
];

// Consulta os itens do inventário
$sql = "SELECT id, numerodepatrimonio, idStatus, idTipo_tabela FROM p4_inventario";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$inventario = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta os status
$sqlStatus = "SELECT idStatus, estado FROM p4_status";
$stmtStatus = $conexao->prepare($sqlStatus);
$stmtStatus->execute();
$statusList = $stmtStatus->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="container" style="margin-bottom: 100px; margin-left: 1px;">
    <div class="pesquisar">
        <input type="text" id="buscaPatrimonio" class="form-control mb-3" placeholder="Digite o número de patrimônio...">
        <button type="button" onclick="buscarRegistro()">Pesquisar</button>

        <div class="tipos">
            <label><input type="checkbox" class="filtroTipo" value="todos" checked> Todos</label>
            <?php foreach ($tabelas as $id => $nome): ?>
                <label>
                    <input type="checkbox" class="filtroTipo" value="<?= str_replace('p4_', '', $nome) ?>" checked> 
                    <?= ucfirst(str_replace('p4_', '', $nome)) ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Número de Patrimônio/ LOTE</th>
                <th>Status</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="tabelaInventario">
            <?php foreach ($inventario as $item): ?>
                <tr data-tipo="<?= str_replace('p4_', '', $tabelas[$item['idTipo_tabela']]) ?>">
                    <td class="patrimonio"><?= htmlspecialchars($item['numerodepatrimonio']) ?></td>
                    <td>
                        <?php
                        $status = array_filter($statusList, function ($statusItem) use ($item) {
                            return $statusItem['idStatus'] == $item['idStatus'];
                        });
                        $status = reset($status);
                        echo $status ? htmlspecialchars($status['estado']) : 'Desconhecido';
                        ?>
                    </td>
                    <td><?= isset($tabelas[$item['idTipo_tabela']]) ? str_replace('p4_', '', $tabelas[$item['idTipo_tabela']]) : "Desconhecido" ?></td>
                    <td>
                    <a href="visualizar_item.php?patrimonio=<?= urlencode($item['numerodepatrimonio']) ?>&tabela=<?= urlencode($tabelas[$item['idTipo_tabela']]) ?>" class="btn btn-info btn-sm">Visualizar</a>
                        <a href="alterar_status.php?id=<?= $item['id'] ?>" class="btn btn-primary btn-sm">Realocar</a>
                        <a href="alterar_status.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm">Alterar Status</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function buscarRegistro() {
    let input = document.getElementById("buscaPatrimonio").value.toLowerCase();
    let linhas = document.querySelectorAll("#tabelaInventario tr");
    let checkboxes = document.querySelectorAll(".filtroTipo:checked");
    let tiposSelecionados = Array.from(checkboxes).map(cb => cb.value);

    linhas.forEach(linha => {
        let patrimonioCell = linha.querySelector(".patrimonio");
        let tipo = linha.getAttribute("data-tipo").toLowerCase(); // Obtém o tipo correto

        if (patrimonioCell) {
            let patrimonio = patrimonioCell.textContent.toLowerCase();
            let correspondePatrimonio = patrimonio.includes(input);
            let correspondeTipo = tiposSelecionados.includes("todos") || tiposSelecionados.includes(tipo);

            linha.style.display = (correspondePatrimonio && correspondeTipo) ? "" : "none";
        }
    });
}

// Atualiza o filtro ao clicar nos checkboxes
document.querySelectorAll(".filtroTipo").forEach(checkbox => {
    checkbox.addEventListener("change", function() {
        let checkTodos = document.querySelector(".filtroTipo[value='todos']");
        let checkboxes = document.querySelectorAll(".filtroTipo:not([value='todos'])");

        if (this.value === "todos") {
            checkboxes.forEach(cb => cb.checked = checkTodos.checked);
        } else {
            let todosMarcados = [...checkboxes].every(cb => cb.checked);
            checkTodos.checked = todosMarcados;
        }

        buscarRegistro();
    });
});
</script>


</body>
</html>
