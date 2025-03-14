<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Romaneio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/inicial.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<style>

html,body{
    background-color:rgb(246, 246, 246); 
}

.hidden {
    display: none;
}
</style>
<body>
<?php require_once("./menu.php"); ?>
    <h1 class="titulo">Romaneio</h1>

    <div id="container" class="d-flex justify-content-around p-3">
       
    <div class="tabela-container" >
        <div class="pesquisar" style="    margin-left: 10px; display: flex;">
            <input type="text" id="buscaPatrimonio" class="form-control mb-3" placeholder="Digite o RE...">
            <button type="button" style="margin-left: 10px; height: 36px;" class="btn btn-primary" onclick="buscarRegistro()">Pesquisar</button>
            </div>
            <div class="titulo"  style="margin-left:20px;  font-family: Arial, sans-serif;; ">controle de alocação</div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="hidden">ID</th>
                        <th>Número de Patrimônio</th>
                        <th>RE</th>
                        <th>status</th>
                        <th>data saida</th>
                        <th>recebimento</th>
                        <th>ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaResultados">
                    <?php require_once("./material_view.php"); ?>
                </tbody>
            </table>
        </div>


    <!-- Div para itens do inventário que estão na tabela p4_controleinventario -->
    <div class="tabela-container" >
        <div class="titulo"  style="margin-left:20px;  font-family: Arial, sans-serif;; ">Itens cadastrados</div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="hidden">ID</th>
                        <th>Número de Patrimônio</th>
                        <th>modelo</th>
                        <th>marca</th>
                        <th>tipo</th>
                        <th>tamanho</th>
                        <th>ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                   foreach ($dados as $row) {
                    echo "<tr>
                            <td class='hidden'>{$row['inventario_id']}</td>
                            <td>{$row['numerodepatrimonio']}</td>
                            <td>{$row['modelo']}</td>
                            <td>{$row['marca']}</td>
                            <td>{$row['descricao']}</td>
                            <td>{$row['descricao_tamanho']}</td>";
                
                    if ($row['estado'] == 'Operando') {
                        echo " <td> <button class='btn btn-success' onclick='locarItem({$row['inventario_id']})'>Locar Item</button></td>";
                    } else {
                        echo "<td>Em operação </td>";
                    }
                
                    echo "</tr>";
                }
                
                    ?>
                </tbody>
            </table>
        </div>
    </div>



    </div>

    <script>
        function buscarRegistro() {
            let re = document.getElementById("buscaPatrimonio").value.trim();

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "./material_view.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("tabelaResultados").innerHTML = xhr.responseText;
                }
            };

            xhr.send("re=" + encodeURIComponent(re));
        }

        function atualizarstatus() {      
            console.log(att);
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "./material_view.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("tabelaResultados").innerHTML = xhr.responseText;
                }
            };

            xhr.send("att=" + encodeURIComponent(att));
        }
        
        
        function darBaixa(inventario_id) {       
    console.log("Enviando ID:", inventario_id);
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./material_view.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("tabelaResultados").innerHTML = xhr.responseText;
        }
    };

    xhr.send("inventario_id=" + encodeURIComponent(inventario_id));
}





    </script>

</body>
</html>
