<!DOCTYPE html>
<html lang="br">

  <?php 
 if (!isset($_SESSION)) {
    session_start();
}

if (!array_key_exists('permissao', $_SESSION)) {
    header('Location: index.php');
    exit();
}
else{

}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Policia Militar :: Visualização de cursos </title>
    <link rel="stylesheet" href="./css/estilo.css">
    <script>
        // Função para buscar os registros em tempo real
        function buscarRegistro() {
            let input = document.getElementById('search').value || ''; // Valor do campo de busca
            let limit = document.getElementById('limit').value || 25; // Limite de registros (padrão 25)

            // Limpa o tbody antes de buscar novos dados
            document.querySelector('tbody').innerHTML = '';

           
            fetch('./atualizar-viewcurso.php?q=' + input + '&limit=' + limit)
                .then(response => response.text()) // Pega a resposta em texto
                .then(data => {
                    document.querySelector('tbody').innerHTML = data; // Atualiza o tbody com os novos dados

                    // Adiciona eventos de mouseover e mouseout após carregar os dados
                    document.querySelectorAll("tbody tr").forEach(row => {
                        row.addEventListener("mouseover", function(event) {
                            const telefone = this.getAttribute("data-telefone");
                            const nome = this.getAttribute("data-nome");
                          

                            const popup = document.getElementById("popup");
                            document.getElementById("telefone").textContent = telefone;
                            document.getElementById("popup-nome").textContent = nome;

                        });

                        row.addEventListener("mouseout", function() {
                            document.getElementById("popup").style.display = "none";
                        });
                    });
                })
                .catch(error => console.error('Erro ao buscar dados:', error));
        }

        // Função para carregar os dados iniciais ao abrir a página
        function carregarDadosIniciais() {
            buscarRegistro(); // Carrega os 25 primeiros registros ao abrir a página
        }

        // Chama a função carregarDadosIniciais quando a página é carregada
        window.onload = carregarDadosIniciais;
    </script>
</head>

<body>
    <?php require_once("./menu.php"); ?>

    <h1 class="titulo">Visualização</h1>

    <div class="search-container">
        <!-- Caixa de busca -->
        <input type="text" id="search" class="search-input" placeholder="Buscar por Nome ou RE" onkeyup="buscarRegistro()" />

        <!-- Seleção para limite de registros -->
        <select id="limit" class="limit-select" onchange="buscarRegistro()">
            <option value="25">25 primeiros</option>
            <option value="50">50 primeiros</option>
            <option value="100">100 primeiros</option>
        </select>
    </div>

    <div id="popup" class="popup" style="display: none;">
        <img id="popup-img" src="" alt="Foto de perfil">
        <p id="popup-nome"></p>
        <p id="telefone"></p>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>NOME</th>
                    <th>RE</th>
                    <th>Nome do curso </th>
                    <th>Data Final</th>
                    <th>exc</th>
                    <?php
                    ?>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</body>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("click", function (event) {
        if (event.target.closest(".btn-excluir")) {
            let idFilho = event.target.closest(".btn-excluir").getAttribute("data-id");

            if (confirm("Tem certeza que deseja excluir este registro?")) {
                fetch("./excurso.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "id_filho=" + idFilho
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Curso excluído com sucesso!");
                        buscarRegistro(); // Atualiza a tabela após a exclusão
                    } else {
                        alert("Erro ao excluir: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Erro:", error);
                    alert("Erro ao processar a solicitação.");
                });
            }
        }
    });
});
</script>

</html>