<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Romaneio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/inicial.css">
    <link rel="stylesheet" href="./pm.css">
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
  $comandoSQL = "
  SELECT 
   inv.id AS inventario_id, 
     inv.*, 
     sta.estado,
     c.*, 
     mo.*, 
     lo.*, 
     ma.*, 
     ti.*, 
     loc.*, 
     tam.*,
     locc.*
 FROM p4_inventario as inv
 INNER JOIN p4_status AS sta ON sta.idStatus = inv.idStatus
 INNER JOIN p4_romaneio AS c ON c.numerodepatrimonio = inv.numerodepatrimonio
 inner join p4_tamanhos  as tam  on  tam.idTamanhos  =  c.id_tamanho  
 INNER JOIN p4_modelos AS mo ON mo.idModelo = c.idModelo
 INNER JOIN p4_localcomplemento AS lo ON lo.idLocComp = inv.idLocComp
 INNER JOIN p4_local AS loc ON loc.idLocal = lo.idLocal
 INNER JOIN p4_complemento AS locc ON locc.idComplemento = lo.idComplemento
 INNER JOIN p4_marcas AS ma ON ma.idMarca = mo.idMarca
 INNER JOIN p4_tipos AS ti ON ti.id = mo.idTipo;
 ";

 $stmt = $conexao->prepare($comandoSQL);
 $stmt->execute();
 $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                   foreach ($dados as $row) {
                    echo "<tr>
                            <td class='hidden'>{$row['inventario_id']}</td>
                            <td>{$row['numerodepatrimonio']}</td>
                            <td>{$row['modelo']}</td>
                            <td>{$row['marca']}</td>
                            <td>{$row['descricao']}</td>
                            <td>{$row['descricao_tamanho']}</td>";
                
                    if ($row['estado'] == 'Baixado') {
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




    <div class="pm" id="pm">
    <div class="pesquisar" style="margin-left: 10px; display: flex;">
        <input type="text" id="buscaPatrimonio" class="form-control mb-3" placeholder="Digite o RE...">
        <label for="idinventario" ></label>
        <input type="hidden" id="idinventario" />
        <button type="button" style="margin-left: 10px; height: 36px;" class="btn btn-primary" onclick="buscarRegistro()">Pesquisar</button>
        <button type="button" style="height: 36px; margin-left:10px" class="btn btn-danger" onclick="voltar()">Voltar</button>
    </div>

    <div class="titulo" style="font-family: Arial, sans-serif;">Alocar</div>

    <table class="table table-striped" style="margin-left: 0px;">
        <thead>
            <tr>
                <th class="hidden">ID</th>
                <th>Nome</th>
                <th>R.E</th>
                <th>Permissão</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $comandoSQL = " 
            SELECT 
                p1.id, 
                p1.NomeCompleto, 
                p1.RE, 
                descricaopermissao.descricao, 
                permissoes.permissao as perm
            FROM 
                p1
            INNER JOIN 
                permissoes 
                ON permissoes.id_pm = p1.id
            INNER JOIN 
                descricaopermissao 
                ON descricaopermissao.id_permissao = permissoes.permissao
            ";

            $stmt = $conexao->prepare($comandoSQL);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dados as $row) {
                echo "<tr>
                    <td class='hidden'>{$row['id']}</td>
                    <td>{$row['NomeCompleto']}</td>
                    <td>{$row['RE']}</td>
                    <td>{$row['descricao']}</td>
                    <td class='hidden'>{$row['perm']}</td>
                    <td>
                        <button class='btn btn-success' onclick='locarpm({$row['id']})'>Locar Item</button>

                    </td>
                </tr>";   
            }
            ?>
        </tbody>
    </table>
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
        
        function darBaixa(inventario_id, id_controle) {       

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./material_view.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
        
            window.location.reload();
            document.getElementById("tabelaResultados").innerHTML = xhr.responseText;
        }
    };

 
    let params = "inventario_id=" + encodeURIComponent(inventario_id) + 
                 "&id_controle=" + encodeURIComponent(id_controle);

    xhr.send(params);
}


function voltar(){
    window.location.reload();

}


function locarItem(id) {
    console.log(id);
    document.getElementById('idinventario').value = id;
    let pmclasse = document.querySelector(".pm");
    pmclasse.style.display = "block"; 
    let botao = document.querySelector(`button[onclick="locarItem(${id})"]`);
    if (botao) {
        botao.classList.remove("btn-success");
        botao.classList.add("btn-warning");
        botao.innerText = "Aguardando"; 
    }
    let idinventario = document.getElementById('idinventario').value
}




function locarpm(id) {

    let idinventario = document.getElementById('idinventario').value;
    console.log("ID do Item:", id);
    console.log("ID do Inventário:", idinventario);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./controleinventariodb.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
        
        window.location.reload();
        }
    };

    let params = "inventario_id=" + encodeURIComponent(idinventario) + 
                 "&idpm=" + encodeURIComponent(id);

    xhr.send(params);






}
    </script>

</body>
</html>
