<?php
require_once("./conexao/conexao.php");
$id                 = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$nome               = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cpf                = filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$rg                 = filter_input(INPUT_POST, "rg", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$data_nascimento    = filter_input(INPUT_POST, "data_nascimento", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$sexo_policial      = filter_input(INPUT_POST, "sexo_policial", FILTER_SANITIZE_NUMBER_INT);
$cnh                = filter_input(INPUT_POST, "cnh", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$categoriacnh       = filter_input(INPUT_POST, "categoriacnh", FILTER_SANITIZE_NUMBER_INT);
$validade           = filter_input(INPUT_POST, "validade", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$nome_pai           = filter_input(INPUT_POST, "nome_pai", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$nome_mae           = filter_input(INPUT_POST, "nome_mae", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$estado_civil       = filter_input(INPUT_POST, "estadocivil", FILTER_SANITIZE_NUMBER_INT);
$logradouro         = filter_input(INPUT_POST, "logradouro", FILTER_SANITIZE_NUMBER_INT);
$endereco           = filter_input(INPUT_POST, "endereco", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$numero             = filter_input(INPUT_POST, "numero", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$bairro             = filter_input(INPUT_POST, "bairro", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cidade             = filter_input(INPUT_POST, "cidade", FILTER_SANITIZE_NUMBER_INT);
$uf                 = filter_input(INPUT_POST, "uf", FILTER_SANITIZE_NUMBER_INT);
$cep                = filter_input(INPUT_POST, "cep", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$complemento        = filter_input(INPUT_POST, "complemento", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$telefone1          = filter_input(INPUT_POST, "telefone1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$celular2           = filter_input(INPUT_POST, "celular2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$celular_Recado     = filter_input(INPUT_POST, "celular_Recado", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$nome_conjuge       = filter_input(INPUT_POST, "nome_conjuge", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$data_nasc_conjuge  = filter_input(INPUT_POST, "data_nascimento_conjuge", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cidadenatal        = filter_input(INPUT_POST, "cidadenatal", FILTER_SANITIZE_NUMBER_INT);
$ufnatal            = filter_input(INPUT_POST, "ufnatal", FILTER_SANITIZE_NUMBER_INT);
$re                 = filter_input(INPUT_POST, "re", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$posto              = filter_input(INPUT_POST, "posto", FILTER_SANITIZE_NUMBER_INT);
$nome_de_guerra     = filter_input(INPUT_POST, "nome_de_guerra", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$data_apresentacao  = filter_input(INPUT_POST, "data_apresentacao", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$data_admissao      = filter_input(INPUT_POST, "data_admissao", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$tipo_sanguineo     = filter_input(INPUT_POST, "tipo_sanguineo", FILTER_SANITIZE_NUMBER_INT);
$categoria_cnh      = filter_input(INPUT_POST, "categoria_cnh", FILTER_SANITIZE_NUMBER_INT);
$email =  $_POST["email"];
$permissao          = $_POST["permissao"];
try {
    // Verifica se uma imagem foi enviada
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto'];

        // Diretório onde a imagem será salva
        $pastaDestino = "./imagempm/";

        // Garante que o diretório existe
        if (!file_exists($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }

        // Define o caminho do arquivo (nome único para evitar substituição de imagens)
        $nomeArquivo = uniqid() . "-" . basename($foto['name']);
        $caminhoArquivo = $pastaDestino . $nomeArquivo;

        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($foto['tmp_name'], $caminhoArquivo)) {
            // Caminho da imagem atualizado com sucesso
            $caminhoImagem = $caminhoArquivo;
        } else {
            echo "<script>alert('Erro ao fazer upload da imagem.');</script>";
            $caminhoImagem = null;
        }
    } else {
        $caminhoImagem = null;
    }

    // Atualiza os dados do banco
    $sql = "UPDATE p1 SET
            NomeCompleto = :nome,
            CPF = :cpf,
            RG = :rg,
            DataNascimento = :data_nascimento,
            Id_Sexo = :sexo_policial,
            CNH = :cnh,
            Id_CategoriaCNH = :categoriacnh,
            ValidadeCNH = :validade,
            NomePai = :nome_pai,
            NomeMae = :nome_mae,
            Id_EstadoCivil = :estado_civil,
            Id_Logradouro = :logradouro,
            Endereco = :endereco,
            Numero = :numero,
            Bairro = :bairro,
            Id_CidadeEndereco = :cidade,
            Id_estadoAtual = :uf,
            CEP = :cep,
            Complemento = :complemento,
            Telefone1 = :telefone1,
            Telefone2 = :celular2,
            TelefoneRecados = :celular_Recado,
            NomeConjuge = :nome_conjuge,
            DtNascConjuge = :data_nasc_conjuge,
            Id_CidadeNatal = :cidadenatal,
            Id_estadoNatal = :ufnatal,
            RE = :re,
            Id_graduacao = :posto,
            NomeGuerra = :nome_de_guerra,
            DtApresentacao = :data_apresentacao,
            DataAdmissao = :data_admissao,
            Id_TipoSanguineo = :tipo_sanguineo,
            Id_SATCNH = :categoria_cnh" .
        ($caminhoImagem ? ", img = :img" : "") . // Adiciona o campo da imagem se houver um novo caminho
        " WHERE id = :id";

    $comandoSQL = $conexao->prepare($sql);

    // Define os valores dos parâmetros
    $params = array(
        ":nome"               => $nome,
        ":cpf"                => $cpf,
        ":rg"                 => $rg,
        ":data_nascimento"    => $data_nascimento,
        ":sexo_policial"      => $sexo_policial,
        ":cnh"                => $cnh,
        ":categoriacnh"       => $categoriacnh,
        ":validade"           => $validade,
        ":nome_pai"           => $nome_pai,
        ":nome_mae"           => $nome_mae,
        ":estado_civil"       => $estado_civil,
        ":logradouro"         => $logradouro,
        ":endereco"           => $endereco,
        ":numero"             => $numero,
        ":bairro"             => $bairro,
        ":cidade"             => $cidade,
        ":uf"                 => $uf,
        ":cep"                => $cep,
        ":complemento"        => $complemento,
        ":telefone1"          => $telefone1,
        ":celular2"           => $celular2,
        ":celular_Recado"     => $celular_Recado,
        ":nome_conjuge"       => $nome_conjuge,
        ":data_nasc_conjuge"  => $data_nasc_conjuge,
        ":cidadenatal"        => $cidadenatal,
        ":ufnatal"            => $ufnatal,
        ":re"                 => $re,
        ":posto"              => $posto,
        ":nome_de_guerra"     => $nome_de_guerra,
        ":data_apresentacao"  => $data_apresentacao,
        ":data_admissao"      => $data_admissao,
        ":tipo_sanguineo"     => $tipo_sanguineo,
        ":categoria_cnh"      => $categoria_cnh,
        ":id"                 => $id
    );

    // Adiciona o caminho da imagem se existir
    if ($caminhoImagem) {
        $params[":img"] = $caminhoImagem;
    }

    // Executa a consulta
    $comandoSQL->execute($params);

    // Atualiza a permissão do usuário
    $comandoSQL2 = $conexao->prepare("
        UPDATE permissoes SET permissao = :permissao WHERE permissoes.id_pm = :id
    ");
    $comandoSQL2->execute(array(
        ":permissao" => $permissao,
        ":id"        => $id
    ));
    
$consultaEmailSQL = "
SELECT email 
FROM email 
WHERE id_pm = :id_pm
";
$stmtEmail = $conexao->prepare($consultaEmailSQL);
$stmtEmail->execute(['id_pm' => $id]);
$emailAtual = $stmtEmail->fetchColumn();

if ($email !== $emailAtual) {

$atualizarEmailSQL = "
    UPDATE email
    SET email = :email
    WHERE id_pm = :id_pm
";
$stmtAtualizarEmail = $conexao->prepare($atualizarEmailSQL);
$stmtAtualizarEmail->execute([
    ':email' => $email,
    ':id_pm' => $id
]);


}

    if ($comandoSQL->rowCount() > 0 || $comandoSQL2->rowCount() > 0 ) {
        echo "<script>
            alert('Alteração foi realizada com sucesso.');
            window.location.href = './visualizacao.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Nenhuma alteração foi realizada.');
            window.location.href = './visualizacao.php';
        </script>";
    }
} catch (PDOException $erro) {
    echo "Erro: Entre em contato com o suporte!";
}
