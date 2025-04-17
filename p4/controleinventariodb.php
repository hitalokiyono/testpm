<?php
require_once("../conexao/conexao.php");


$id_pm = trim($_POST['idpm']);
$idinventario = trim($_POST['inventario_id']);
$comando = "INSERT INTO `p4_controleinventario`
    (`id_controle`, `idPm`, `idInventario`, `dtEntrada`, `dtSaida`) 
VALUES 
    (NULL, :id_pm, :idinventario, NOW(), NULL)";

$stmt = $conexao->prepare($comando);
$stmt->bindParam(":id_pm", $id_pm, PDO::PARAM_STR);
$stmt->bindParam(":idinventario", $idinventario, PDO::PARAM_STR); 
$stmt->execute();



$comandoSQL = "
    UPDATE p4_inventario 
    SET idStatus = 1 
    WHERE p4_inventario.id = :idinventario;
";


$stmt = $conexao->prepare($comandoSQL);
$stmt->bindParam(":idinventario", $idinventario, PDO::PARAM_STR);  
$stmt->execute();


