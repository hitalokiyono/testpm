<?php
require_once("./conexao/conexao.php");

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


if (isset($_SESSION['id_cad'])) {
    $_Atualcad = $_SESSION['id_cad'];

} else {
    $_Atualcad = $_POST["id_atual"];
    var_dump( $_Atualcad);

}
// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitização dos inputs
    $nomeCurso = filter_input(INPUT_POST, 'nome_do_curso', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $dtTermino = filter_input(INPUT_POST, 'dt_termino', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    // Verifica se há pelo menos um curso preenchido
    if (is_array($nomeCurso) && !empty(array_filter($nomeCurso))) {

        // Prepara a query de inserção no banco de dados
        $sql = "INSERT INTO p1cursos (id_p1, NomeCurso, AnoConclusao) 
                VALUES (:id_p1, :NomeCurso,:DtTermino)";
        $stmt = $conexao->prepare($sql);

        // Itera sobre os cursos enviados
        foreach ($nomeCurso as $index => $curso) {

            $nome = filter_var(trim($curso), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $inicio = filter_var(trim($dtInicio[$index]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $termino = filter_var(trim($dtTermino[$index]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Verifica se o nome do curso não está vazio
            if (!empty($nome)) {
                // Atribui os valores para os parâmetros
                $stmt->bindParam(':id_p1', $_Atualcad);
                $stmt->bindParam(':NomeCurso', $nome);
                $stmt->bindParam(':DtTermino', $termino);
                try {
                    // Executa a inserção para cada curso
                    $stmt->execute();
                } catch (PDOException $erro) {
                    echo "Erro ao cadastrar curso: " . $erro->getMessage();
                    exit;
                }
            }
        }
    }


    $_SESSION['permissao'];


    if (isset($_SESSION['id_atual'])) {
        header("Location: ./inicial.php");
        exit();
    } else {
        // Verifica se a permissão está definida antes de acessá-la
        if (isset($_SESSION['permissao']) && $_SESSION['permissao'] > 0) {
            header("Location: ./visualizacao.php");
        } 
        else {     
            header("Location: ./index.php");
        }
        exit();
    }
} else {
    echo "Método de requisição inválido.";
}
