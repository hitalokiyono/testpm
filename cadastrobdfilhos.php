<?php
require_once("./conexao/conexao.php");

session_start(); // Inicia a sessão

// Verifica se a sessão contém o ID do policial
if (isset($_SESSION['id_cad'])) {
    $_Atualcad = $_SESSION['id_cad'];

} else {
    $_Atualcad = $_POST["id_atual"];

}

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitização dos inputs
    $nomeFilho = filter_input(INPUT_POST, 'nome_filho', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $sexoFilho = filter_input(INPUT_POST, 'sexo_filho', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $dataNascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    // Verifica se há pelo menos um filho preenchido
    if (is_array($nomeFilho) && !empty(array_filter($nomeFilho))) {

        // Prepara a query de inserção no banco de dados
        $sql = "INSERT INTO p1filhos (id_p1, NomeFilho, DtNascimento, Id_Sexo) 
                VALUES (:id_p1, :NomeFilho, :DtNascimento, :Id_Sexo)";
        $stmt = $conexao->prepare($sql);

        // Itera sobre os filhos enviados
        foreach ($nomeFilho as $index => $filho) {

            $nome = filter_var(trim($filho), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexo = filter_var(trim($sexoFilho[$index]), FILTER_SANITIZE_NUMBER_INT);
            $dataNasc = filter_var(trim($dataNascimento[$index]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Verifica se o nome do filho não está vazio
            if (!empty($nome)) {
                // Atribui os valores para os parâmetros
                $stmt->bindParam(':id_p1', $_Atualcad);
                $stmt->bindParam(':NomeFilho', $nome);
                $stmt->bindParam(':DtNascimento', $dataNasc);
                $stmt->bindParam(':Id_Sexo', $sexo);
                try {
                    // Executa a inserção para cada filho
                    $stmt->execute();
                } catch (PDOException $erro) {
                    echo "Erro ao cadastrar filho: " . $erro->getMessage();
                    exit;
                }
            }
        }
    } else {
        echo "Nenhum filho foi fornecido, passando para a próxima etapa.";
    }

    if (isset($_SESSION['id_atual'])) {
       header("Location: ./inicial.php");
        exit();
    } else {
        header("location:./cadastrocurso.php");
    }
} else {
    echo "Método de requisição inválido.";
}
