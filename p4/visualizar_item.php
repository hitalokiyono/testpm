<?php
require_once("../conexao/conexao.php");
try {
    
    $idpatrimonio = $_GET['patrimonio'];
    $tabela = $_GET['tabela'];

    $tabelas = [
        'p4_armas' => [
            'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, a.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*',
            'joins' => 'INNER JOIN p4_armas AS a ON a.numerodepatrimonio = inv.numerodepatrimonio
                        INNER JOIN p4_modelos AS mo ON mo.idModelo = a.idModelo
                        INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                        INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                        INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
            'where' => 'a.numerodepatrimonio = :idpatrimonio'
        ],
        'p4_coletes' => [
            'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, c.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*',
            'joins' => 'INNER JOIN p4_coletes AS c ON c.numerodepatrimonio = inv.numerodepatrimonio
                        INNER JOIN p4_modelos AS mo ON mo.idModelo = c.idModelo
                        INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                        INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                        INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
            'where' => 'c.numerodepatrimonio = :idpatrimonio'
        ],
        'p4_tpd' => [
            'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, tpd.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*',
            'joins' => 'INNER JOIN p4_tpd AS tpd ON tpd.numerodepatrimonio = inv.numerodepatrimonio
                        INNER JOIN p4_modelos AS mo ON mo.idModelo = tpd.idModelo
                        INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                        INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                        INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
            'where' => 'tpd.numerodepatrimonio = :idpatrimonio'
        ],
        'p4_municoes' => [
            'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, mun.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*',
            'joins' => 'INNER JOIN p4_municoes AS mun ON mun.numerodepatrimonio = inv.numerodepatrimonio
                        INNER JOIN p4_modelos AS mo ON mo.idModelo = mun.idModelo
                        INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                        INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                        INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
            'where' => 'mun.numerodepatrimonio = :idpatrimonio'
        ],
        'p4_taser' => [
            'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, taser.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*',
            'joins' => 'INNER JOIN p4_taser AS taser ON taser.numerodepatrimonio = inv.numerodepatrimonio
                        INNER JOIN p4_modelos AS mo ON mo.idModelo = taser.idModelo
                        INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                        INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                        INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
            'where' => 'taser.numerodepatrimonio = :idpatrimonio'
        ],
        'p4_algemas' => [
            'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, algemas.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*',
            'joins' => 'INNER JOIN p4_algemas AS algemas ON algemas.numerodepatrimonio = inv.numerodepatrimonio
                        INNER JOIN p4_modelos AS mo ON mo.idModelo = algemas.idModelo
                        INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                        INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                        INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
            'where' => 'algemas.numerodepatrimonio = :idpatrimonio'
        ],
        'p4_ht' => [
            'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, ht.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*',
            'joins' => 'INNER JOIN p4_ht AS ht ON ht.numerodepatrimonio = inv.numerodepatrimonio
                        INNER JOIN p4_modelos AS mo ON mo.idModelo = ht.idModelo
                        INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                        INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                        INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
            'where' => 'ht.numerodepatrimonio = :idpatrimonio'
        ],
        'p4_material' => [
            'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, material.*, mo.*, st.*, lo.*,  loc.*, locc.*',
            'joins' => 'INNER JOIN p4_material AS material ON material.numerodepatrimonio = inv.numerodepatrimonio
                        INNER JOIN p4_modelos AS mo ON mo.idModelo = material.idModelo
                        INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                     ',
            'where' => 'material.numerodepatrimonio = :idpatrimonio'
        ],
        'p4_viaturas' => [
            'fields' => 'inv.id, inv.numerodepatrimonio, inv.idLocComp, inv.idStatus, inv.idTipo_tabela, viaturas.*, mo.*, st.*, lo.*, ma.*, ti.*, loc.*, locc.*',
            'joins' => 'INNER JOIN p4_viaturas AS viaturas ON viaturas.numerodepatrimonio = inv.numerodepatrimonio
                        INNER JOIN p4_modelos AS mo ON mo.idModelo = viaturas.Modelo
                        INNER JOIN p4_status AS st ON st.idStatus = inv.idStatus
                        INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
                        INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
                        INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
                        INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
                        INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo',
            'where' => 'viaturas.numerodepatrimonio = :idpatrimonio'
        ]

    ];

if (!isset($tabelas[$tabela])) {
    echo "Tabela não encontrada.";
    exit;
}

// Monta a consulta SQL dinamicamente
$comandoSQL = 'SELECT ' . $tabelas[$tabela]['fields'] . ' 
               FROM p4_inventario AS inv 
               ' . $tabelas[$tabela]['joins'] . ' 
               WHERE ' . $tabelas[$tabela]['where'];

// Preparação e execução da consulta
$stmt = $conexao->prepare($comandoSQL);
$stmt->bindValue(':idpatrimonio', $idpatrimonio, PDO::PARAM_STR); // Ajuste para PDO::PARAM_STR ou PDO::PARAM_INT dependendo do tipo de dado
$stmt->execute();

// Recupera o resultado
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['dados_exportacao'] = $resultado;

if ($resultado) {

} else {
    echo "Nenhum dado encontrado.";
}
   
} catch (PDOException $erro) {
    echo "<tr><td colspan='5' align='center'>Erro ao realizar a busca: " . $erro->getMessage() . "</td></tr>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Patrimônio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/inicial.css">
    <?php require_once("./menu.php"); ?>
    <style>
        /* Estilo para ocultar o restante da página durante a impressão */
        @media print {
            body * {
                visibility: hidden; /* Oculta tudo na página */
            }

            .printable, .printable * {
                visibility: visible; /* Exibe apenas a div com a classe "printable" */
            }

            .print-photo {
                visibility: visible !important; /* Exibe a foto somente na impressão */
                margin-top: 20px;
                width: 100%;
            }

        }

        @media print {
            .foto-campo {
                display: none !important;
            }
        }

        /* Foto inicialmente escondida na tela */
        .print-photo {
            display: none; /* Esconde a foto na visualização normal */
        }

        html,body {
            width: 100%;
            background-color: rgb(238, 241, 239);
        }

        table{
            margin-left: 1%;
        }

        .container {
            display: contents;
            width: 100%; /* Tamanho automático */
            height: auto; /* Tamanho automático */
            margin: 0; /* Removendo qualquer margem */
            margin-left: 0; /* Resetando margem esquerda */
            padding: 0; /* Removendo padding */
        }

        .table_sccs {
            width: 90%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="titulo">Detalhes do Patrimônio</h2>

        <!-- Div para exibir a tabela e a foto durante a impressão -->
        <div class="printable">
            <table class="table table-bordered" style="width: 98%;">
                <tbody>
                    <?php
                    foreach ($resultado as $campo => $valor) {
                        // Pula campos que começam com 'id' ou são exatamente 'Categoria'
                        if (stripos($campo, 'id') === 0 || strtolower($campo) === "categoria") {
                            continue;  
                        }
                        if ($campo === 'foto') continue; // Pula o campo foto por enquanto
                        echo "<tr><th>" . ucfirst($campo) . "</th><td>" . htmlspecialchars($valor) . "</td></tr>";
                    }

                    if (isset($resultado['foto'])) {
                        echo "<tr class='foto-campo'><th>Foto</th><td><button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#fotoModal'>Ver Foto</button></td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Exibição da foto abaixo da tabela -->
            <?php if (isset($resultado['foto'])): ?>
                <div class="text-center print-photo">
                    <img src="../fotoitens/<?php echo htmlspecialchars($tabela . '/' . $resultado['foto'] ?? ''); ?>" alt="Foto do Patrimônio" class="img-fluid">
                </div>
            <?php endif; ?>
        </div>

        <!-- Botões no final -->
        <div class="text-begin" style="margin-left:2%;">
            <button onclick="history.back();" class="btn btn-secondary">Voltar</button>
            <a href="relocar.php" class="btn btn-warning">Relocar</a>
            <button onclick="imprimirComFoto();" class="btn btn-info">Imprimir</button>
            <a href="editar.php" class="btn btn-success">Editar</a>
            <a href="exce.php" class="btn btn-primary">Exportar para Excel</a> <!-- Botão de exportação -->
        </div>
    </div>

    <!-- Modal para exibir a foto -->
    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fotoModalLabel">Foto do Patrimônio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="../fotoitens/<?php echo htmlspecialchars($tabela . '/' . $resultado['foto'] ?? ''); ?>" alt="Foto do Patrimônio" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script>
        function imprimirComFoto() {
            var fotoDiv = document.querySelector('.print-photo');
            var fotoCampo = document.querySelector('.foto-campo'); // Linha da foto

            // Verifica se o campo foto existe antes de tentar esconder
            if (fotoCampo) {
                fotoCampo.style.display = 'none'; // Esconde a linha da foto
            }

            // Verifica se a foto existe antes de tentar manipulá-la
            if (fotoDiv) {
                fotoDiv.style.display = 'block'; // Exibe a foto na impressão
            }

            // Atraso de 500ms para garantir que a foto seja visível antes da impressão
            setTimeout(function() {
                window.print(); // Imprime a página
            }, 500);

            // Após a impressão, a foto será escondida novamente
            setTimeout(function() {
                if (fotoDiv) {
                    fotoDiv.style.display = 'none'; // Esconde a foto novamente após a impressão
                }
                if (fotoCampo) {
                    fotoCampo.style.display = ''; // Restaura a linha Foto na página
                }
            }, 1000); // Foto é escondida após 1 segundo
        }
    </script>
</body>
</html>
