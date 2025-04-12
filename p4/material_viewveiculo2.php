<?php
require_once("../conexao/conexao.php");
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_POST['viaturafiltro'])) {
$comandoSQL = "select * from p4_viaturas
";
$stmt = $conexao->prepare($comandoSQL);
$stmt->execute();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($dados) > 0) {
    foreach ($dados as $row) {
        echo "<tr id='linha-{$row['idViaturas']}'>
                <td class='hidden'>{$row['idViaturas']}</td>
                <td>{$row['placa']}</td>
                <td>{$row['prefixo']}</td>
                <td>{$row['numerodepatrimonio']}</td>";
        if ($_SESSION["permissao"] == 5) {
            echo "<td>
<button class='btn btn-warning marcar-viatura' onclick='marcarviaturas({$row['idViaturas']})'>Marcar</button>

                  </td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>Nenhum registro encontrado.</td></tr>";
}
}else{
    $viaturafiltro = trim($_POST['viaturafiltro']);

    $comandoSQL = "SELECT * FROM p4_viaturas 
                   WHERE placa LIKE :viaturafiltro";
    $stmt = $conexao->prepare($comandoSQL);
    
    $viaturafiltro = "%$viaturafiltro%";
    $stmt->bindParam(":viaturafiltro", $viaturafiltro, PDO::PARAM_STR);
    
    $stmt->execute();
    
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($dados) > 0) {
        foreach ($dados as $row) {
            echo "<tr id='linha-{$row['idViaturas']}'>
                    <td class='hidden'>{$row['idViaturas']}</td>
                    <td>{$row['placa']}</td>
                    <td>{$row['prefixo']}</td>
                    <td>{$row['numerodepatrimonio']}</td>";
            if ($_SESSION["permissao"] == 5) {
                echo "<td>
    <button class='btn btn-warning marcar-viatura' onclick='marcarviaturas({$row['idViaturas']})'>Marcar</button>
    
                      </td>";
            }
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5' class='text-center'>Nenhum registro encontrado.</td></tr>";
    }


}
