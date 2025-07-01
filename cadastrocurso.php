<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cadastrarcurso.css">
    <title>Policia Militar :: Cadastro de curso</title>
</head>

<body>



    <?php require_once("./menu.php"); ?>
    <h1 class="titulo">Cadastro de curso</h1>
    <form action="cadastrobdcursos.php" method="post" enctype="multipart/form-data">
    <?php

if (!isset($_SESSION)) {
    session_start();
}
        if (isset($_SESSION['id_cad'])) {
            echo '<input type="hidden" name="id_atual" value="' . $_SESSION['id_cad'] . '">';
        } else {
            echo '<input type="hidden" name="id_atual" value="' . $_SESSION['id_atual'] . '">';
        }
        if (isset($_GET['id'])) {
            echo '<input type="hidden" name="id_atual" value="' . $_GET['id'] . '">';
        }
        ?>
        <div class="container">

            <div class="step active" id="step-5">

                <div class="container-form" id="cursos-container">
                    <div class="curso-group">
                        <div class="row">
                            <div class="col">
                                <label for="nome_do_curso">Nome do curso</label>
                                <input type="text" name="nome_do_curso[]" placeholder="Descreva o nome do curso.">
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col">
                                <label for="dt_termino">Data de término</label>
                                <input type="date" name="dt_termino[]" placeholder="Insira a data de término">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-buttom">
                    <div class="row">
                        <div class="col">
                            <button class="voltar-btn">VOLTAR</button>
                            <button type="button" id="botao-add" onclick="addCurso()">Adicionar mais Curso</button>
                            <input type="submit" value="FINALIZAR">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="steps.js" defer></script>
    <!-- <script src="foto.js" defer></script> -->
    <script src="scripts/addcursos.js" defer></script>
</body>

</html>