<?php
// Inicia a sessão se não estiver iniciada
if (!isset($_SESSION)) {
    session_start();
}

try {
    require_once("../conexao/conexao.php");

    $id_locacao = $_GET['idlocacao'] ?? null;
    if (!$id_locacao) {
        throw new Exception("ID de locação não fornecido");
    }

    // Consulta da locação
    $sqlLocacao = 'SELECT lv.id_locacao, lv.datainicio, lv.datafim, lv.id_setor,
                          vi.placa, vi.prefixo,
                          inv.id AS id_inventario,
                          mo.modelo,
                          f.funcao,
                          dp.descricao AS permissao,
                          p1.RE, p1.NomeCompleto, p1.img
                   FROM locacao_viatura AS lv
                   INNER JOIN p4_inventario AS inv ON lv.id_viatura = inv.id
                   INNER JOIN p4_viaturas AS vi ON inv.numerodepatrimonio = vi.numerodepatrimonio
                   INNER JOIN p4_funcao AS f ON lv.id_funcao = f.id_funcao
                   INNER JOIN p1 ON lv.id_p1responsavel = p1.id
                   INNER JOIN permissoes AS per ON p1.id = per.id_pm
                   INNER JOIN descricaopermissao AS dp ON per.permissao = dp.id_permissao
                   INNER JOIN p4_viaturas AS via ON inv.numerodepatrimonio = via.numerodepatrimonio
                   INNER JOIN p4_modelos AS mo ON via.Modelo = mo.idModelo
                   WHERE lv.id_locacao = :id_locacao';

    $stmtLocacao = $conexao->prepare($sqlLocacao);
    $stmtLocacao->bindValue(':id_locacao', $id_locacao, PDO::PARAM_INT);
    $stmtLocacao->execute();
    $detalhesLocacao = $stmtLocacao->fetch(PDO::FETCH_ASSOC);

    // Consulta os tipos de tabela relacionados
    $comandoSQL1 = 'SELECT tipo.tipo FROM 
                   materias_viaturas AS mate 
                   INNER JOIN p4_controleinventario AS con ON con.id_controle = mate.id_controleinventario
                   INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
                   INNER JOIN p4_tipo_tabelas AS tipo ON tipo.id_tabela = inv.idTipo_tabela
                   WHERE mate.id_alocacao = :idlocacao';                        

    $stmt1 = $conexao->prepare($comandoSQL1);
    $stmt1->bindValue(':idlocacao', $id_locacao, PDO::PARAM_INT);
    $stmt1->execute();
    $tiposTabelas = $stmt1->fetchAll(PDO::FETCH_ASSOC);



    $configTabelas = [ 'p4_armas' => [
            'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, a.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*, mate.*',
            'joins' => 'INNER JOIN p4_controleinventario AS con ON con.id_controle = mate.id_controleinventario
                        INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
                        INNER JOIN p4_armas AS a ON a.numerodepatrimonio = inv.numerodepatrimonio
                        INNER JOIN p4_modelos AS mo ON mo.idModelo = a.idModelo
                        INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                        INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                        INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
            'from' => 'materias_viaturas AS mate',
            'where' => 'mate.id_alocacao = :idlocacao'
        ],
        'p4_coletes' => [
        'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, c.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*, mate.*',
        'joins' => 'INNER JOIN p4_controleinventario AS con ON con.id_controle = mate.id_controleinventario
                    INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
                    INNER JOIN p4_coletes AS c ON c.numerodepatrimonio = inv.numerodepatrimonio
                    INNER JOIN p4_modelos AS mo ON mo.idModelo = c.idModelo
                    INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                    INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                    INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                    INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                    INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                    INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
        'from' => 'materias_viaturas AS mate',
        'where' => 'mate.id_alocacao = :idlocacao'
    ],
    'p4_tpd' => [
        'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, tpd.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*, mate.*',
        'joins' => 'INNER JOIN p4_controleinventario AS con ON con.id_controle = mate.id_controleinventario
                    INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
                    INNER JOIN p4_tpd AS tpd ON tpd.numerodepatrimonio = inv.numerodepatrimonio
                    INNER JOIN p4_modelos AS mo ON mo.idModelo = tpd.idModelo
                    INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                    INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                    INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                    INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                    INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                    INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
        'from' => 'materias_viaturas AS mate',
        'where' => 'mate.id_alocacao = :idlocacao'
    ],
    'p4_municoes' => [
        'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, mun.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*, mate.*',
        'joins' => 'INNER JOIN p4_controleinventario AS con ON con.id_controle = mate.id_controleinventario
                    INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
                    INNER JOIN p4_municoes AS mun ON mun.numerodepatrimonio = inv.numerodepatrimonio
                    INNER JOIN p4_modelos AS mo ON mo.idModelo = mun.idModelo
                    INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                    INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                    INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                    INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                    INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                    INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
        'from' => 'materias_viaturas AS mate',
        'where' => 'mate.id_alocacao = :idlocacao'
    ],
    'p4_taser' => [
        'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, taser.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*, mate.*',
        'joins' => 'INNER JOIN p4_controleinventario AS con ON con.id_controle = mate.id_controleinventario
                    INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
                    INNER JOIN p4_taser AS taser ON taser.numerodepatrimonio = inv.numerodepatrimonio
                    INNER JOIN p4_modelos AS mo ON mo.idModelo = taser.idModelo
                    INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                    INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                    INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                    INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                    INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                    INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
        'from' => 'materias_viaturas AS mate',
        'where' => 'mate.id_alocacao = :idlocacao'
    ],
    'p4_algemas' => [
        'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, algemas.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*, mate.*',
        'joins' => 'INNER JOIN p4_controleinventario AS con ON con.id_controle = mate.id_controleinventario
                    INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
                    INNER JOIN p4_algemas AS algemas ON algemas.numerodepatrimonio = inv.numerodepatrimonio
                    INNER JOIN p4_modelos AS mo ON mo.idModelo = algemas.idModelo
                    INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                    INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                    INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                    INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                    INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                    INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
        'from' => 'materias_viaturas AS mate',
        'where' => 'mate.id_alocacao = :idlocacao'
    ],
    'p4_ht' => [
        'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, ht.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*, mate.*',
        'joins' => 'INNER JOIN p4_controleinventario AS con ON con.id_controle = mate.id_controleinventario
                    INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
                    INNER JOIN p4_ht AS ht ON ht.numerodepatrimonio = inv.numerodepatrimonio
                    INNER JOIN p4_modelos AS mo ON mo.idModelo = ht.idModelo
                    INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                    INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                    INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                    INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                    INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                    INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
        'from' => 'materias_viaturas AS mate',
        'where' => 'mate.id_alocacao = :idlocacao'
    ],
    'p4_material' => [
        'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, material.*, mo.*, st.*, lo.*, loc.*, locc.*, mate.*',
        'joins' => 'INNER JOIN p4_controleinventario AS con ON con.id_controle = mate.id_controleinventario
                    INNER JOIN p4_inventario AS inv ON inv.id = con.idInventario
                    INNER JOIN p4_material AS material ON material.numerodepatrimonio = inv.numerodepatrimonio
                    INNER JOIN p4_modelos AS mo ON mo.idModelo = material.idModelo
                    INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                    INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                    INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                    INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento',
        'from' => 'materias_viaturas AS mate',
        'where' => 'mate.id_alocacao = :idlocacao'
    ]]; 

    $todosResultados = [];

    foreach ($tiposTabelas as $tipoTabela) {
        $nomeTabela = $tipoTabela['tipo'] ?? null;
        if (!$nomeTabela || !array_key_exists($nomeTabela, $configTabelas)) continue;

        $config = $configTabelas[$nomeTabela];

        $comandoSQL = 'SELECT ' . $config['fields'] . ' 
                       FROM ' . $config['from'] . ' 
                       ' . $config['joins'] . ' 
                       WHERE ' . $config['where'];

        $stmt = $conexao->prepare($comandoSQL);
        $stmt->bindValue(':idlocacao', $id_locacao, PDO::PARAM_INT);
        $stmt->execute();

        while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado['tipo_tabela'] = $nomeTabela;
            $todosResultados[] = $resultado;
        }
    }

    $_SESSION['dados_exportacao'] = $todosResultados;

} catch (PDOException $erro) {
    echo "<div class='alert alert-danger'>Erro no banco de dados: " . htmlspecialchars($erro->getMessage()) . "</div>";
    exit;
} catch (Exception $erro) {
    echo "<div class='alert alert-warning'>" . htmlspecialchars($erro->getMessage()) . "</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Operação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hidden {
    display: none;
}

        .card-item {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .card-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }
        .table-details {
            width: 100%;
            margin-bottom: 0;
        }
        .table-details th {
            width: 30%;
        }
        .section-header {
            background-color: #0d6efd;
            color: white;
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 6px;
        }
    </style>
</head>
<body>


<div class="container my-4">
    <div class="section-header mb-3">
        <h4 class="mb-0">Resumo da Locação</h4>
    </div>

    <?php if (!empty($detalhesLocacao)): ?>
        <div class="card mb-4">
            <div class="card-body">

                <?php 
                $camposOcultos = ['id', 'observacao', 'id_locacao', 'id_setor', 'id_inventario', 'img'];
                $grupoPessoal = ['NomeCompleto', 'RE', 'permissao'];
                $grupoViatura = ['placa', 'prefixo', 'modelo'];
                $grupoGeral = ['datainicio', 'datafim', 'funcao'];

                function mostrarGrupo($titulo, $grupo, $dados, $classe) {
                    echo "<h5 class=\"mb-2\">$titulo</h5>";
                    echo "<table class=\"table table-bordered mb-4\">";
                    foreach ($grupo as $campo) {
                        if (isset($dados[$campo]) || $campo === 'datafim') {
                            $valor = $dados[$campo];
                            if ($campo === 'datafim') {
                                $valorExibido = (is_null($valor) || $valor === 'NULL') ? 'Operando' : htmlspecialchars($valor);
                            } else {
                                $valorExibido = (is_null($valor) || $valor === 'NULL') ? 'Em operação' : htmlspecialchars($valor);
                            }
                            echo "<tr class=\"$classe\"><th>{$campo}</th><td>{$valorExibido}</td></tr>";
                        }
                    }
                    echo "</table>";
                }

                mostrarGrupo("🧍 Dados Pessoais", $grupoPessoal, $detalhesLocacao, 'linha-pessoal');

                // Imagem dentro dos dados pessoais
                if (isset($detalhesLocacao['img'])) {
                    echo "<table class=\"table table-bordered mb-4\">";
                    echo "<tr class=\"linha-pessoal\"><th>Foto</th><td>";
                    if (is_null($detalhesLocacao['img']) || $detalhesLocacao['img'] === 'NULL') {
                        echo "Em operação";
                    } else {
                        $src = '.' . htmlspecialchars($detalhesLocacao['img']);
                        echo "<img src=\"$src\" alt=\"Foto\" class=\"img-thumbnail\" style=\"max-height: 150px;\">";
                    }
                    echo "</td></tr>";
                    echo "</table>";
                }

                mostrarGrupo("🚗 Dados da Viatura", $grupoViatura, $detalhesLocacao, 'linha-viatura');
                mostrarGrupo("📅 Dados Gerais", $grupoGeral, $detalhesLocacao, 'linha-geral');
                ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Dados da locação não encontrados.</div>
    <?php endif; ?>
</div>


<div class="container my-4">
    <div class="section-header bg-success">
        <h4 class="mb-0">Materiais Vinculados à Locação</h4>
    </div>

    <?php if (!empty($todosResultados)): ?>
        <?php foreach ($todosResultados as $index => $resultado): ?>
            <div class="card card-item">
                <div class="card-header">
                    <h6 class="mb-0">Item <?= $index + 1 ?> - Tipo: <?= htmlspecialchars($resultado['tipo_tabela'] ?? 'Desconhecido') ?></h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-details">
                        <tbody>
                            <?php foreach ($resultado as $chave => $valor): ?>
                                <?php if ($chave !== 'tipo_tabela'): ?>
                                    <tr>
                                        <th><?= htmlspecialchars($chave) ?></th>
                                        <td><?= is_null($valor) ? 'NULL' : htmlspecialchars($valor) ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning">Nenhum material encontrado para esta locação.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
