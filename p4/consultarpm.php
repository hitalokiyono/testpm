<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>visualizar materias alocação</title>
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
<?php require_once("./menu.php");

if (!isset($_SESSION)) {
    session_start();
}

?>
    <h1 class="titulo">visualizar materias alocação</h1>
    <div id="container" class="d-flex justify-content-around p-3">
    <div class="tabela-container" >
 <?php if ($_SESSION['permissao'] >= 4): ?>
    <div class="pesquisar" style="margin-left: 10px; display: flex; justify-content: center;">
        <input type="text" id="buscaPatrimonio" class="form-control mb-3" placeholder="Digite o RE...">
        <button type="button" style="margin-left: 10px; height: 36px;" class="btn btn-primary" onclick="buscarRegistro()">Pesquisar</button>
    </div>
<?php endif; ?>

            <div class="titulo"  style="margin-left:20px;  font-family: Arial, sans-serif;; ">controle de alocação</div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="hidden">ID</th>
                        <th>Nome Completo</th>
                        <th>RE</th>
                        <th>material</th>
                        <th>numero de  patrimonio</th>
                        <th>status</th>
                        <th>data saida</th>
                        <th>recebimento</th>
                        <?php
                        if($_SESSION['permissao'] == '5' ){
                echo'<th>Ações</th>';
                }
                   ?>
                    </tr>
                </thead>
                <tbody id="tabelaResultados">
                    <?php require_once("./material_view_pm.php"); ?>
                </tbody>
            </table>
        </div>

   
    <script>
        function buscarRegistro() {
            let re = document.getElementById("buscaPatrimonio").value.trim();

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "./material_view_pm.php", true);
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


function alocar() {
    window.location.href = "./romaneio.php";
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

function buscarRegistro2() {
        let re = document.getElementById("buscaPatrimonio2").value.trim();

     
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "pmpesquisar.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("tabelaResultados2").innerHTML = xhr.responseText;
            }
        };

        xhr.send("re=" + encodeURIComponent(re));
    }

    // Carregar os dados ao abrir a página
    window.onload = function () {
        buscarRegistro2(""); // Carregar todos os registros inicialmente
    };
    </script>

</body>
</html>
