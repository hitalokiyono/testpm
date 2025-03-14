<?php
require '../vendor/autoload.php'; // Certifique-se de que o caminho do autoload está correto

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Aqui você já tem o array $resultado vindo da outra página
// Exemplo: $resultado = [ 'campo1' => 'valor1', 'campo2' => 'valor2', ... ]


if (!isset($_SESSION)) {
    session_start();
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();



$resultado = $_SESSION['dados_exportacao'];

// Adicionar cabeçalhos de coluna (nomes dos campos)
$col = 'A'; // Começando na coluna A
foreach ($resultado as $campo => $valor) {
    // Pula campos que começam com 'id' ou são exatamente 'Categoria'
    if (stripos($campo, 'id') === 0 || strtolower($campo) === "categoria" ||  strtolower($campo) === "foto") {
        continue;  
    }

    $sheet->setCellValue($col . '1', ucfirst($campo)); // Definindo os cabeçalhos (na primeira linha)
    $col++; // Avançar para a próxima coluna
}

// Adicionar os valores abaixo dos cabeçalhos
$row = 2; // Começar pela segunda linha (logo abaixo dos cabeçalhos)
$col = 'A'; // Começar novamente pela coluna A
foreach ($resultado as $campo => $valor) {
    // Pula campos que começam com 'id' ou são exatamente 'Categoria'
    if (stripos($campo, 'id') === 0 || strtolower($campo) === "categoria") {
        continue;
    }
    
    if ($campo === 'foto') continue; // Pula o campo foto por enquanto

    $sheet->setCellValue($col . $row, $valor); // Adicionar o valor na célula correspondente
    $col++; // Avançar para a próxima coluna
}

// Formatar cabeçalhos (negrito)
$sheet->getStyle('A1:H1')->getFont()->setBold(true);

// Definir largura das colunas para melhor visualização
foreach(range('A', 'H') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Gerar arquivo Excel
$writer = new Xlsx($spreadsheet);

// Enviar o arquivo Excel para o navegador
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="patrimonio.xlsx"');
header('Cache-Control: max-age=0');

// Salvar e enviar para o navegador
$writer->save('php://output');
exit;
?>
