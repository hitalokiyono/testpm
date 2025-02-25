<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilofilho.css">
    <title>Controle Policia Militar :: Cadastro de filhos</title>

</head>

<body>

    <?php
    require_once("./menu.php");
    ?>
    <h1 class="titulo">Cadastro de filhos</h1>
    <form action="cadastrobdfilhos.php" method="post" enctype="multipart/form-data">
    
        <?php
        if (isset($_SESSION['id_cad'])) {
            echo '<input type="hidden" name="id_atual" value="' . $_SESSION['id_cad'] . '">';
        } else {
            echo '<input type="hidden" name="id_atual" value="' . $_SESSION['id_atual'] . '">';
        }
        if (isset($_GET['id'])) {
            echo '<input type="hidden" name="id_atual" value="' . $_GET['id'] . '">';
        }
        ?>

        <div class="step active" id="step-4">
            <div class="container">
                <div class="container-form">
                    <div class="container-filhos" id="container-filhos">
                        <div class="filho-group">
                            <div class="row">
                                <div class="col">
                                    <label for="nome_filho1">Nome do filho</label>
                                    <input type="text" name="nome_filho[]" id="nome_filho" placeholder="Nome do filho.">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="sexo_filho">Sexo</label>

                                    <!-- Conectar com o banco e fazer o select -->
                                    <?php
                                    require_once("./conexao/conexao.php");

                                    try {
                                        $comandoSQL = "SELECT * FROM sexo";

                                        // Executa o comandoSQL no banco QUERY
                                        $dadosSelecionados = $conexao->query($comandoSQL);

                                        // Coloca os dados em formato de matriz
                                        $dados = $dadosSelecionados->fetchAll();
                                    } catch (PDOException $erro) {
                                        echo ("Entre em contato com o suporte!");
                                    }
                                    ?>
                                    <select name="sexo_filho[]" id="sexo_filho">
                                        <?php
                                        foreach ($dados as $linha) {
                                        ?>
                                            <option value="<?= $linha['id']; ?>"><?= $linha["Descricao"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="data_nascimento">Data de nascimento</label>
                                    <input type="date" name="data_nascimento[]" id="data_nascimento" placeholder="Data de nascimento.">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-buttom">
                <div class="row">
                    <div class="col">
                        <button type="button" id="botao-add" onclick="addFilho()">Adicionar mais filhos</button>
                        <input type="submit" value="PRÓXIMO">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function addFilho() {
            const filhosContainer = document.getElementById('container-filhos');
            const filhoGroup = document.createElement('div');
            filhoGroup.className = 'filho-group';
            filhoGroup.innerHTML = `
        <div class="row">
            <div class="col">
                <label for="nome_filho">Nome do filho</label>
                <input type="text" name="nome_filho[]" id="nome_filho" placeholder="Nome do filho.">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="sexo_filho">Sexo</label>
                
                <select name="sexo_filho[]" id="sexo_filho">
                    <?php
                    foreach ($dados as $linha) {
                    ?>
                        <option value="<?= $linha['id']; ?>"><?= $linha["Descricao"]; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="data_nascimento">Data de nascimento</label>
                <input type="date" name="data_nascimento[]" id="data_nascimento">
            </div>
        </div>
    `;
            filhosContainer.appendChild(filhoGroup);
        }
    </script>
</body>

</html>