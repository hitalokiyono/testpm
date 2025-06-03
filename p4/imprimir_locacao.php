
<?php
require_once("../conexao/conexao.php");

// Receber parâmetros
$ids = isset($_GET['ids']) ? explode(',', $_GET['ids']) : [];
$dataFiltro = $_GET['data'] ?? '';
$turno = $_GET['turno'] ?? 'DIURNO'; // DIURNO ou NOTURNO
$statusFiltro = $_GET['status'] ?? 'todos';

function formatarDataPt($data) {
    if (empty($data)) return '';
    
    $meses = [
        '01' => 'janeiro', '02' => 'fevereiro', '03' => 'março', '04' => 'abril',
        '05' => 'maio', '06' => 'junho', '07' => 'julho', '08' => 'agosto',
        '09' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
    ];

    $dataObj = new DateTime($data);
    $dia = $dataObj->format('d');
    $mes = $meses[$dataObj->format('m')];
    $ano = $dataObj->format('Y');

    return "$dia de $mes de $ano";
}

$dataFormatada = !empty($dataFiltro) ? formatarDataPt($dataFiltro) : '';

// Consulta para obter os dados das locações
$sql = "SELECT 
    lv.id_locacao, 
    GROUP_CONCAT(DISTINCT setr.setor ORDER BY setr.setor SEPARATOR ' , ') AS setores,
    DATE(lv.datainicio) as data_inicio,
    TIME(lv.datainicio) as hora_inicio,
    DATE(lv.datafim) as data_fim,
    TIME(lv.datafim) as hora_fim,
    vi.prefixo,
    f.funcao,
    f.local,
    gr.posto,
    GROUP_CONCAT(DISTINCT p1.NomeCompleto SEPARATOR ' , ') as policiais
FROM locacao_viatura AS lv
INNER JOIN p4_inventario AS inv ON lv.id_viatura = inv.id
INNER JOIN locacao_setor as setr on setr.id_locacao = lv.id_locacao
INNER JOIN p4_viaturas AS vi ON inv.numerodepatrimonio = vi.numerodepatrimonio
INNER JOIN p4_funcao AS f ON lv.id_funcao = f.id_funcao
INNER JOIN p1 ON lv.id_p1responsavel = p1.id
INNER JOIN graduacao as gr on gr.id = p1.Id_graduacao";


// Aplicar filtros
$where = [];
$params = [];

if (!empty($ids)) {
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $where[] = "lv.id_locacao IN ($placeholders)";
    foreach ($ids as $id) {
        $params[] = $id;
    }
}

if (!empty($dataFiltro)) {
    if ($statusFiltro === 'operacao') {
        $where[] = "DATE(lv.datainicio) = ?";
        $params[] = $dataFiltro;
    } elseif ($statusFiltro === 'finalizadas') {
        $where[] = "DATE(lv.datafim) = ?";
        $params[] = $dataFiltro;
    } elseif ($statusFiltro === 'todos') {
        $where[] = "(DATE(lv.datainicio) = ? OR DATE(lv.datafim) = ?)";
        $params[] = $dataFiltro;
        $params[] = $dataFiltro;
    }
}

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}


$sql .= " GROUP BY 
    lv.id_locacao, 
    DATE(lv.datainicio),
    TIME(lv.datainicio),
    DATE(lv.datafim),
    TIME(lv.datafim),
    vi.prefixo,
    f.funcao,
    f.local,
    gr.posto";

$sql .= " ORDER BY f.funcao, vi.prefixo";


$stmt = $conexao->prepare($sql);
$stmt->execute($params);
$viaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obter todas as modalidades/locais distintos
$sqlModalidades = "SELECT DISTINCT local FROM p4_funcao ORDER BY local";
$stmtModalidades = $conexao->prepare($sqlModalidades);
$stmtModalidades->execute();
$modalidadesDB = $stmtModalidades->fetchAll(PDO::FETCH_COLUMN);

// Agrupar viaturas por modalidade/função
$modalidades = [];
foreach ($viaturas as $viatura) {
    $funcao = $viatura['funcao'];
    if (!isset($modalidades[$funcao])) {
        $modalidades[$funcao] = [
            'local' => $viatura['local'],
            'viaturas' => []
        ];
    }
    $modalidades[$funcao]['viaturas'][] = $viatura;
}

// Contar viaturas por modalidade para a seção de designação
$designacao = [];
foreach ($modalidades as $funcao => $dados) {
    $designacao[$dados['local']] = count($dados['viaturas']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title> Equipe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: white; color: black; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1, .header h2 { margin: 5px 0; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .no-border td {
            border: none;
            padding: 3px;
        }
        .footer {
            text-align: right;
            margin-top: 30px;
            font-size: 0.8em;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 10px; font-size: 15px; }
            table { font-size: 12px; }
        }
        .modalidade-title {
            background-color:rgb(199, 196, 196);
            font-weight: bold;
            padding: 5px;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        
        @page {
    margin: 1cm;
    size: auto;
}

@media print {
    body {
        display: block;
    }

    /* Remove o cabeçalho e rodapé padrão do navegador (incluindo a URL) */
    @page {
        margin: 0;
    }
}
.modalidade-title {
    background-color: rgb(199, 196, 196);
    font-weight: bold;
    padding: 5px;
    margin-top: 15px;
    margin-bottom: 5px;
}

@media print {
    .modalidade-title {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        background-color: rgb(199, 196, 196) !important;
    }
}

    
    </style>
</head>
<body>
    <div class="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <img src="../img/pm_logo.png" alt="PMESP" style="height: 80px;">
            <div>
                <h1>MAPA FORÇA <?= $turno ?></h1>
                <?php if (!empty($dataFormatada)): ?>
                    <h2><?= $dataFormatada ?></h2>
                <?php endif; ?>
            </div>
            <img src="../img/bpmi.png" alt="2º BPM/I" style="height: 80px;">
        </div>
    </div>

    <?php foreach ($modalidades as $funcao => $dados): ?>
        <div class="modalidade-title"><?= strtoupper($dados['local']) ?></div>

        <table>
            <thead>
                <tr>
                    <th width="15%">MODALIDADE</th>
                    <th width="10%">PREFIXO</th>
                    <th width="40%">EQUIPE</th>
                    <th width="15%">INÍCIO</th>
                    <th width="15%">TÉRMINO</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados['viaturas'] as $viatura): ?>
                    <tr>
                        <td><?= htmlspecialchars($funcao." setores ".$viatura['setores']) ?></td>
                        <td><?= htmlspecialchars($viatura['prefixo'] ?? '') ?></td>
                        <td><?= htmlspecialchars($viatura['posto'] ." " .$viatura['policiais'] ?? '') ?></td>
                        <td><?= date('H:i', strtotime($viatura['hora_inicio']."")) ?></td>
                        <td>
                            <?= !empty($viatura['hora_fim']) ? date('H:i', strtotime($viatura['hora_fim']."")) : '--:--' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>

    <div class="modalidade-title">DESIGNAÇÃO DAS VIATURAS</div>
    <table>
        <tbody>
            <?php foreach ($modalidadesDB as $modalidade): ?>
                <tr>
                    <td width="70%"><?= $modalidade ?></td>
                    <td width="30%"><?= $designacao[$modalidade] ?? 0 ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>As viaturas somente serão modificadas com autorização do CFP mediante aprovação do Cmt Cia:CAP PM SPINA.</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <form method="get" action="">
            <input type="hidden" name="ids" value="<?= implode(',', $ids) ?>">
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" value="<?= $dataFiltro ?>">
            
            <label for="turno">Turno:</label>
            <select id="turno" name="turno">
                <option value="DIURNO" <?= $turno == 'DIURNO' ? 'selected' : '' ?>>Diurno</option>
                <option value="NOTURNO" <?= $turno == 'NOTURNO' ? 'selected' : '' ?>>Noturno</option>
            </select>
            
            <input type="hidden" name="status" value="<?= $statusFiltro ?>">
            
            <button type="submit">Filtrar</button>
            <button type="button" onclick="window.print()">Imprimir</button>
        </form>
    </div>
</body>
</html>
