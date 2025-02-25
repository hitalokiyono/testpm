<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Policia Militar :: Visualização</title>
    <link rel="stylesheet" href="./css/estilo.css">
    <script>
        // Função para buscar os registros em tempo real
        function buscarRegistro() {
            let input = document.getElementById('search').value || ''; // Valor do campo de busca
            let limit = document.getElementById('limit').value || 25; // Limite de registros (padrão 25)

            // Limpa o tbody antes de buscar novos dados
            document.querySelector('tbody').innerHTML = '';

            // Faz a requisição usando fetch
            fetch('./visualizacaobd.php?q=' + input + '&limit=' + limit)
                .then(response => response.text()) // Pega a resposta em texto
                .then(data => {
                    document.querySelector('tbody').innerHTML = data; // Atualiza o tbody com os novos dados

                    // Adiciona eventos de mouseover e mouseout após carregar os dados
                    document.querySelectorAll("tbody tr").forEach(row => {
                        row.addEventListener("mouseover", function(event) {
                            const telefone = this.getAttribute("data-telefone");
                            const nome = this.getAttribute("data-nome");
                            const imgSrc = this.getAttribute("data-img");

                            const popup = document.getElementById("popup");
                            document.getElementById("telefone").textContent = telefone;
                            document.getElementById("popup-nome").textContent = nome;
                            document.getElementById("popup-img").src = imgSrc;

                            popup.style.display = "block";
                            popup.style.top = `${event.clientY + 10}px`;
                            popup.style.left = `${event.clientX + 10}px`;
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
                    <th>ativo</th>
                    <th>ED</th>
                    <?php
                    if ($_SESSION['permissao'] === 5  ||  $_SESSION['permissao'] === 1) {
                        echo '<th>EX</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</body>

</html>