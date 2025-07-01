<?php
// Sanitização dos inputs
$Id_Atual = filter_input(INPUT_POST, "id_atual", FILTER_SANITIZE_NUMBER_INT);
$RE = filter_input(INPUT_POST, "re", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$NomeCompleto = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$NomeGuerra = filter_input(INPUT_POST, "nome_de_guerra", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$DataNascimento = filter_input(INPUT_POST, "data_nascimento", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$DataAdmissao = filter_input(INPUT_POST, "data_admissao", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Id_TipoSanguineo = filter_input(INPUT_POST, "tiposanguineo", FILTER_SANITIZE_NUMBER_INT);
$Id_CidadeNatal = filter_input(INPUT_POST, "cidadenatalId", FILTER_SANITIZE_NUMBER_INT);
$Id_CidadeEndereco = filter_input(INPUT_POST, "cidadeId", FILTER_SANITIZE_NUMBER_INT);
$NomePai = filter_input(INPUT_POST, "nome_pai", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$NomeMae = filter_input(INPUT_POST, "nome_mae", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Id_EstadoCivil = filter_input(INPUT_POST, "estadocivil", FILTER_SANITIZE_NUMBER_INT);
$CPF = filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$RG = filter_input(INPUT_POST, "rg", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$CNH = filter_input(INPUT_POST, "cnh", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$ValidadeCNH = filter_input(INPUT_POST, "validade", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Id_CategoriaCNH = filter_input(INPUT_POST, "categoriacnh", FILTER_SANITIZE_NUMBER_INT);
$Id_SATCNH = filter_input(INPUT_POST, "categoria_cnh", FILTER_SANITIZE_NUMBER_INT);
$CEP = filter_input(INPUT_POST, "cep", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Endereco = filter_input(INPUT_POST, "endereco", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Numero = filter_input(INPUT_POST, "numero", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Id_Logradouro = filter_input(INPUT_POST, "logradouro", FILTER_SANITIZE_NUMBER_INT);
$Bairro = filter_input(INPUT_POST, "bairro", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Complemento = filter_input(INPUT_POST, "complemento", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$NomeConjuge = filter_input(INPUT_POST, "nome_conjuge", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$DtNascConjuge = filter_input(INPUT_POST, "data_nascimento_conjuge", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Id_Sexo = filter_input(INPUT_POST, "sexo_policial", FILTER_SANITIZE_NUMBER_INT);
$Telefone1 = filter_input(INPUT_POST, "telefone1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Telefone2 = filter_input(INPUT_POST, "celular2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TelefoneRecados = filter_input(INPUT_POST, "celular_Recado", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Id_graduacao = filter_input(INPUT_POST, "posto", FILTER_SANITIZE_NUMBER_INT);
$Id_estadoAtual = filter_input(INPUT_POST, "uf", FILTER_SANITIZE_NUMBER_INT);
$Id_estadoNatal = filter_input(INPUT_POST, "ufnatal", FILTER_SANITIZE_NUMBER_INT);
$DtApresentacao = filter_input(INPUT_POST, "data_apresentacao", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


// Verifica se o arquivo foi enviado sem erros
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    // Caminho para a pasta onde as imagens serão armazenadas
    $diretorio = 'imagempm/';

    // Nome do arquivo (pode adicionar um prefixo, caso necessário)
    $nomeArquivo = basename($_FILES['foto']['name']);

    // Caminho final onde o arquivo será movido
    $caminhoArquivo = $diretorio . $nomeArquivo;

    // Move o arquivo para a pasta de destino
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoArquivo)) {
        // Agora armazene o caminho no banco de dados, e não o conteúdo do arquivo
        $img = $caminhoArquivo;
    } else {
        // Caso ocorra algum erro ao mover o arquivo
        echo "Erro ao fazer upload da imagem.";
        $img = null;
    }
} else {
    // Caso não tenha enviado nenhuma imagem
    echo "Nenhuma imagem foi enviada.";
    $img = null;
}

// Após o upload, o restante do seu código para inserir os dados no banco de dados

try {
    require_once("./conexao/conexao.php");

    // Verifique se a conexão foi bem-sucedida
    if (!$conexao) {
        throw new Exception("Erro ao conectar com o banco de dados.");
    }

    // Preparação da query SQL para inserção
    $comandoSQL = $conexao->prepare("
        INSERT INTO p1 (
            RE,
            NomeCompleto,
            NomeGuerra,
            DataNascimento,
            DataAdmissao,
            Id_TipoSanguineo,
            Id_CidadeNatal,
            Id_CidadeEndereco,
            NomePai,
            NomeMae,
            Id_EstadoCivil,
            CPF,
            RG,
            CNH,
            ValidadeCNH,
            Id_CategoriaCNH,
            Id_SATCNH,
            CEP,
            Endereco,
            Numero,
            Id_Logradouro,
            Bairro,
            Complemento,
            NomeConjuge,
            DtNascConjuge,
            Id_Sexo,
            Telefone1,
            Telefone2,
            TelefoneRecados,
            img,
            Id_graduacao,
            Id_estadoAtual,
            Id_estadoNatal,
            DtApresentacao
        ) VALUES (
            :RE,
            :NomeCompleto,
            :NomeGuerra,
            :DataNascimento,
            :DataAdmissao,
            :Id_TipoSanguineo,
            :Id_CidadeNatal,
            :Id_CidadeEndereco,
            :NomePai,
            :NomeMae,
            :Id_EstadoCivil,
            :CPF,
            :RG,
            :CNH,
            :ValidadeCNH,
            :Id_CategoriaCNH,
            :Id_SATCNH,
            :CEP,
            :Endereco,
            :Numero,
            :Id_Logradouro,
            :Bairro,
            :Complemento,
            :NomeConjuge,
            :DtNascConjuge,
            :Id_Sexo,
            :Telefone1,
            :Telefone2,
            :TelefoneRecados,
            :img,
            :Id_graduacao,
            :Id_estadoAtual,
            :Id_estadoNatal,
            :DtApresentacao
        )
    ");

    // Execução da query
    $comandoSQL->execute(array(
        ":RE"              => $RE,
        ":NomeCompleto"    => $NomeCompleto,
        ":NomeGuerra"      => $NomeGuerra,
        ":DataNascimento"  => $DataNascimento,
        ":DataAdmissao"    => $DataAdmissao,
        ":Id_TipoSanguineo" => $Id_TipoSanguineo,
        ":Id_CidadeNatal"  => $Id_CidadeNatal,
        ":Id_CidadeEndereco" => $Id_CidadeEndereco,
        ":NomePai"         => $NomePai,
        ":NomeMae"         => $NomeMae,
        ":Id_EstadoCivil"  => $Id_EstadoCivil,
        ":CPF"             => $CPF,
        ":RG"              => $RG,
        ":CNH"             => $CNH,
        ":ValidadeCNH"     => $ValidadeCNH,
        ":Id_CategoriaCNH" => $Id_CategoriaCNH,
        ":Id_SATCNH"       => $Id_SATCNH,
        ":CEP"             => $CEP,
        ":Endereco"        => $Endereco,
        ":Numero"          => $Numero,
        ":Id_Logradouro"   => $Id_Logradouro,
        ":Bairro"          => $Bairro,
        ":Complemento"     => $Complemento,
        ":NomeConjuge"     => $NomeConjuge,
        ":DtNascConjuge"   => $DtNascConjuge,
        ":Id_Sexo"         => $Id_Sexo,
        ":Telefone1"       => $Telefone1,
        ":Telefone2"       => $Telefone2,
        ":TelefoneRecados" => $TelefoneRecados,
        ":img"             => $img,
        ":Id_graduacao"    => $Id_graduacao,
        ":Id_estadoAtual"  => $Id_estadoAtual,
        ":Id_estadoNatal"  => $Id_estadoNatal,
        ":DtApresentacao" => $DtApresentacao
    ));

    session_start();
    $_SESSION["id_cad"] = $conexao->lastInsertId();

if (!isset($_SESSION["email"])) {
    $_SESSION["email"] = 'genericoemail@gmail.com';
}



    if ($comandoSQL->rowCount() > 0) {
        // Adicionando permissao nas linhas 166 a 168
        $comandoSQL1 = $conexao->prepare("INSERT INTO email (id_email, email, ativo, id_pm ) VALUES (null, :email, 0,:id_atual)");
        $comandoSQL1->execute(array(":email" => $_SESSION["email"], ":id_atual" => $_SESSION["id_cad"]));
        if ($comandoSQL1->rowCount() > 0) {
            

        $comandoSQL2 = $conexao->prepare("INSERT INTO permissoes (id_permissao, id_pm, permissao) VALUES (null, :id_atual, 0)");
        $comandoSQL2->execute(array(":id_atual" => $_SESSION["id_cad"]));

        if ($comandoSQL2->rowCount() > 0) {
            // Busca o valor de 'permissao' da última inserção para definir na sessão
            $selectPermissao = $conexao->prepare("SELECT permissao FROM permissoes WHERE id_permissao = :last_id");
            $selectPermissao->execute(array(":last_id" => $conexao->lastInsertId()));
            $resultado = $selectPermissao->fetch(PDO::FETCH_ASSOC);
            header("location:./cadastrofilho.php");
            exit();
        }
    } else {
        echo "Erro na inserção.";
    }
}
 }catch (PDOException $erro) {
    echo "Erro ao conectar com o banco de dados: " . $erro->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
