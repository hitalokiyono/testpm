<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilo-atualizar.css">
    <title>Policia Militar :: Visualizar dados</title>
</head>

<body>

    <?php require_once("./menu.php"); ?>

    <h1 class="titulo">Policia Militar :: Visualizar dados</h1>
    <?php
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    require_once("./atualizar-view.php");
    ?>
    <form action="./atualizarbd.php" method="post">
        <div class="container">
            <label for="foto" style="cursor:pointer;">
                <img id='thumb' src="./img/usuario.png" alt="imagem de perfil">
            </label>
            <input type="file" name="foto" id="foto" accept="image/*">
            <div class="container-form">
                <input
                    type="hidden"
                    name="id"
                    id="id"
                    value="<?= $resultado['id']; ?>">

                <div class="row">
                    <div class="col">
                        <label for="nome">Nome</label>
                        <input
                            type="text"
                            name="nome"
                            id="nome"
                            value="<?= $resultado['NomeCompleto']; ?>"
                            placeholder="Nome completo do usuário." disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="cpf">CPF</label>
                        <input
                            type="text"
                            name="cpf"
                            id="cpf"
                            value="<?= $resultado['CPF']; ?>"
                            oninput="mascaraCPF(this)"
                            maxlength="14"
                            onblur="validarDados('cpf',document.getElementById('cpf').value)"
                            placeholder="Ex: xxx.xxx.xxx-xx"
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="rg">RG</label>
                        <input
                            type="text"
                            name="rg"
                            id="rg"
                            value="<?= $resultado['RG']; ?>"
                            onblur="validarDados('rg',document.getElementById('rg').value)"
                            oninput="mascaraRG(this)"
                            placeholder="RG do policial."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="data_nascimento">Data de nascimento</label>
                        <input
                            type="date"
                            name="data_nascimento"
                            id="data_nascimento"
                            value="<?= $resultado['DataNascimento']; ?>"
                            onblur="validarDados('data_nascimento',document.getElementById('data_nascimento').value)"
                            placeholder="Data de nascimento."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="sexo_policial">Sexo</label>
                        <?php
                        require_once("./conexao/conexao.php");
                        try {
                            $comandoSQL = "SELECT * FROM sexo";
                            $dadosSelecionados = $conexao->query($comandoSQL);
                            $dados = $dadosSelecionados->fetchAll();
                        } catch (PDOException $erro) {
                            echo ("Entre em contato com o suporte!");
                        }
                        ?>
                        <select
                            name="sexo_policial"
                            id="sexo_policial"
                            onblur="validarDados('Id_Sexo',document.getElementById('sexo_policial').value)"
                            required disabled>
                            <option value="">Selecione as opções</option>
                            <?php foreach ($dados as $linha) { ?>
                                <option value="<?= $linha['id']; ?>" <?= $resultado['Id_Sexo'] == $linha['id'] ? 'selected' : '' ?>><?= $linha["Descricao"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="cnh">CNH</label>
                        <input
                            type="text"
                            name="cnh"
                            id="cnh"
                            value="<?= $resultado['CNH']; ?>"
                            maxlength="11"
                            placeholder="CNH do policial."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="categoria_cnh">Categoria CNH</label>
                        <?php
                        require_once("./conexao/conexao.php");
                        try {
                            $comandoSQL = "SELECT * FROM categoriacnh";
                            $dadosSelecionados = $conexao->query($comandoSQL);
                            $dados = $dadosSelecionados->fetchAll();
                        } catch (PDOException $erro) {
                            echo ("Entre em contato com o suporte!");
                        }
                        ?>
                        <select
                            name="categoriacnh"
                            id="categoriacnh"
                            onblur="validarDados('categoriacnh',document.getElementById('categoriacnh').value)"
                            required disabled>
                            <option value="">Selecione a categoria da CNH</option>
                            <?php foreach ($dados as $linha) { ?>
                                <option value="<?= $linha['id']; ?>" <?= $resultado['Id_CategoriaCNH'] == $linha['id'] ? 'selected' : '' ?>><?= $linha["categoria"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="validade">Validade CNH</label>
                        <input
                            type="date"
                            name="validade"
                            id="validade"
                            value="<?= $resultado['ValidadeCNH']; ?>"
                            onblur="validarDados('validade',document.getElementById('validade').value)"
                            placeholder="Validade da CNH."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="nome_pai">Nome do pai</label>
                        <input
                            type="text"
                            name="nome_pai"
                            id="nome_pai"
                            value="<?= $resultado['NomePai']; ?>"
                            onblur="validarDados('nome_pai',document.getElementById('nome_pai').value)"
                            placeholder="Nome do pai."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="nome_mae">Nome da mãe</label>
                        <input
                            type="text"
                            name="nome_mae"
                            id="nome_mae"
                            value="<?= $resultado['NomeMae']; ?>"
                            onblur="validarDados('nome_mae',document.getElementById('nome_mae').value)"
                            placeholder="Nome da mãe."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="estado_civil">Estado civil</label>
                        <?php
                        require_once("./conexao/conexao.php");
                        try {
                            $comandoSQL = "SELECT * FROM estadocivil";
                            $dadosSelecionados = $conexao->query($comandoSQL);
                            $dados = $dadosSelecionados->fetchAll();
                        } catch (PDOException $erro) {
                            echo ("Entre em contato com o suporte!");
                        }
                        ?>
                        <select
                            name="estadocivil"
                            id="estadocivil"
                            onblur="validarDados('estadocivil',document.getElementById('estadocivil').value)"
                            required disabled>
                            <option value="">Selecione as opções</option>
                            <?php foreach ($dados as $linha) { ?>
                                <option value="<?= $linha['id']; ?>" <?= $resultado['Id_EstadoCivil'] == $linha['id'] ? 'selected' : '' ?>><?= $linha["estado"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="endereco">Endereço</label>
                        <input
                            type="text"
                            name="endereco"
                            id="endereco"
                            value="<?= $resultado['Endereco']; ?>"
                            onblur="validarDados('endereco',document.getElementById('endereco').value)"
                            placeholder="Endereço."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="numero">Numero</label>
                        <input
                            type="text"
                            name="numero"
                            id="numero"
                            value="<?= $resultado['Numero']; ?>"
                            onblur="validarDados('numero',document.getElementById('numero').value)"
                            placeholder="Numero."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="bairro">Bairro</label>
                        <input
                            type="text"
                            name="bairro"
                            id="bairro"
                            value="<?= $resultado['Bairro']; ?>"
                            onblur="validarDados('bairro',document.getElementById('bairro').value)"
                            placeholder="Bairro."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="cidade">Cidade Atual</label>
                        <?php
                        try {
                            $comandoSQL = "SELECT id, nome FROM cidades";
                            $dadosSelecionados = $conexao->query($comandoSQL);
                            $dados = $dadosSelecionados->fetchAll();
                        } catch (PDOException $erro) {
                            echo ("Entre em contato com o suporte!");
                        }
                        ?>
                        <select name="cidade" id="cidade" onblur="validarDados('cidade',document.getElementById('cidade').value)" required disabled>
                            <option value="">Selecione as opções</option>
                            <?php foreach ($dados as $linha) { ?>
                                <option value="<?= $linha['id']; ?>" <?= $resultado['Id_CidadeEndereco'] == $linha['id'] ? 'selected' : '' ?>><?= $linha['nome']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="uf">UF Atual</label>
                        <?php
                        try {
                            $comandoSQL = "SELECT * FROM estados";
                            $dadosSelecionados = $conexao->query($comandoSQL);
                            $dados = $dadosSelecionados->fetchAll();
                        } catch (PDOException $erro) {
                            echo ("Entre em contato com o suporte!");
                        }
                        ?>
                        <select name="uf" id="uf" onblur="validarDados('uf', document.getElementById('uf').value)" required disabled>
                            <option value="">Selecione o estado</option>
                            <?php foreach ($dados as $linha) { ?>
                                <option value="<?= $linha['id']; ?>" <?= $resultado['Id_estadoAtual'] == $linha['id'] ? 'selected' : '' ?>><?= $linha['uf']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="cep">CEP</label>
                        <input
                            type="text"
                            name="cep"
                            id="cep"
                            value="<?= $resultado['CEP']; ?>"
                            onblur="validarDados('cep',document.getElementById('cep').value)"
                            oninput="mascaraCEP(this)"
                            maxlength="9"
                            placeholder="Digite seu CEP"
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="complemento">Complemento</label>
                        <input
                            type="text"
                            name="complemento"
                            id="complemento"
                            value="<?= $resultado['Complemento']; ?>"
                            placeholder="Ex: Bloco 800 apt 665" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="telefone1">Celular 1</label>
                        <input
                            type="text"
                            name="telefone1"
                            id="telefone1"
                            value="<?= $resultado['Telefone1']; ?>"
                            onblur="validarDados('telefone1',document.getElementById('telefone1').value)"
                            oninput="mascaraTelefone(this)"
                            maxlength="15"
                            placeholder="Digite seu celular xx xxxxx-xxxx."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="celular2">Celular 2</label>
                        <input
                            type="text"
                            name="celular2"
                            id="celular2"
                            value="<?= $resultado['Telefone2']; ?>"
                            maxlength="15"
                            placeholder="Celular 2 opcional." disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="celular_Recado">Celular de Recado</label>
                        <input
                            type="text"
                            name="celular_Recado"
                            id="celular_Recado"
                            value="<?= $resultado['TelefoneRecados']; ?>"
                            onblur="validarDados('celular_Recado',document.getElementById('celular_Recado').value)"
                            oninput="mascaraTelefone(this)"
                            maxlength="15"
                            placeholder="Digite seu celular xx xxxxx-xxxx."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="nome_conjuge">Nome do cônjuge</label>
                        <input
                            type="text"
                            name="nome_conjuge"
                            id="nome_conjuge"
                            value="<?= $resultado['NomeConjuge']; ?>"
                            onblur="validarDados('nome_conjuge',document.getElementById('nome_conjuge').value)"
                            placeholder="Nome do cônjuge." disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="data_nascimento_conjuge">Data de nascimento do cônjuge</label>
                        <input
                            type="date"
                            name="data_nascimento_conjuge"
                            id="data_nascimento_conjuge"
                            value="<?= $resultado['DtNascConjuge']; ?>"
                            onblur="validarDados('data_nascimento_conjuge',document.getElementById('data_nascimento_conjuge').value)"
                            placeholder="Data de nascimento do cônjuge." disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="cidadenatal">Cidade Natal</label>
                        <?php
                        try {
                            $comandoSQL = "SELECT * FROM cidades";
                            $dadosSelecionados = $conexao->query($comandoSQL);
                            $dados = $dadosSelecionados->fetchAll();
                        } catch (PDOException $erro) {
                            echo ("Entre em contato com o suporte!");
                        }
                        ?>
                        <select name="cidadenatal" id="cidadenatal" onblur="validarDados('cidadenatal',document.getElementById('cidadenatal').value)" required disabled>
                            <option value="">Selecione a cidade</option>
                            <?php foreach ($dados as $linha) { ?>
                                <option value="<?= $linha['id']; ?>" <?= $resultado['Id_CidadeNatal'] == $linha['id'] ? 'selected' : '' ?>><?= $linha['nome']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="ufnatal">UF Natal</label>
                        <?php
                        try {
                            $comandoSQL = "SELECT * FROM estados";
                            $dadosSelecionados = $conexao->query($comandoSQL);
                            $dados = $dadosSelecionados->fetchAll();
                        } catch (PDOException $erro) {
                            echo ("Entre em contato com o suporte!");
                        }
                        ?>
                        <select name="ufnatal" id="ufnatal" onblur="validarDados('ufnatal', document.getElementById('ufnatal').value)" required disabled>
                            <option value="">Selecione o estado</option>
                            <?php foreach ($dados as $linha) { ?>
                                <option value="<?= $linha['id']; ?>" <?= $resultado['Id_estadoNatal'] == $linha['id'] ? 'selected' : '' ?>><?= $linha['uf']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="re">RE</label>
                        <input
                            type="text"
                            name="re"
                            id="re"
                            value="<?= $resultado['RE']; ?>"
                            onblur="validarDados('re', document.getElementById('re').value)"
                            oninput="mascaraRE(this)"
                            placeholder="Digite o seu RE."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="posto">Posto/Graduação</label>
                        <?php
                        require_once("./conexao/conexao.php");
                        try {
                            $comandoSQL = "SELECT * FROM graduacao";
                            $dadosSelecionados = $conexao->query($comandoSQL);
                            $dados = $dadosSelecionados->fetchAll();
                        } catch (PDOException $erro) {
                            echo ("Entre em contato com o suporte!");
                        }
                        ?>
                        <select name="posto" id="posto" onblur="validarDados('posto', document.getElementById('posto').value)" required disabled>
                            <option value="">Selecione as opções</option>
                            <?php foreach ($dados as $linha) { ?>
                                <option value="<?= $linha['id']; ?>" <?= $resultado['Id_graduacao'] == $linha['id'] ? 'selected' : '' ?>><?= $linha["posto"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="nome_de_guerra">Nome de guerra</label>
                        <input
                            type="text"
                            name="nome_de_guerra"
                            id="nome_de_guerra"
                            value="<?= $resultado['NomeGuerra']; ?>"
                            onblur="validarDados('nome_de_guerra', document.getElementById('nome_de_guerra').value)"
                            placeholder="Nome de guerra."
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="data_apresentacao">Data de apresentação</label>
                        <input
                            type="date"
                            name="data_apresentacao"
                            id="data_apresentacao"
                            value="<?= $resultado['DtApresentacao']; ?>"
                            onblur="validarDados('data_apresentacao', document.getElementById('data_apresentacao').value)"
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="data_admissao">Data de Admissão</label>
                        <input
                            type="date"
                            name="data_admissao"
                            id="data_admissao"
                            value="<?= $resultado['DataAdmissao']; ?>"
                            onblur="validarDados('data_admissao', document.getElementById('data_admissao').value)"
                            required disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="tipo_sanguineo">Tipo sanguíneo</label>
                        <?php
                        try {
                            $comandoSQL = "SELECT * FROM tiposanguineo";
                            $dadosSelecionados = $conexao->query($comandoSQL);
                            $dados = $dadosSelecionados->fetchAll();
                        } catch (PDOException $erro) {
                            echo ("Entre em contato com o suporte!");
                        }
                        ?>
                        <select name="tipo_sanguineo" id="tipo_sanguineo" onblur="validarDados('tipo_sanguineo', document.getElementById('tipo_sanguineo').value)" required disabled>
                            <option value="">Selecione as opções</option>
                            <?php foreach ($dados as $linha) { ?>
                                <option value="<?= $linha['id']; ?>" <?= $resultado['Id_TipoSanguineo'] == $linha['id'] ? 'selected' : '' ?>><?= $linha["tipo"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="categoria_cnh">CAT/SAT</label>
                        <?php
                        try {
                            $comandoSQL = "SELECT * FROM categoriacnh";
                            $dadosSelecionados = $conexao->query($comandoSQL);
                            $dados = $dadosSelecionados->fetchAll();
                        } catch (PDOException $erro) {
                            echo ("Entre em contato com o suporte!");
                        }
                        ?>
                        <select name="categoria_cnh" id="categoria_cnh" onblur="validarDados('categoria_cnh', document.getElementById('categoria_cnh').value)" required disabled>
                            <option value="">Selecione as opções</option>
                            <?php foreach ($dados as $linha) { ?>
                                <option value="<?= $linha['id']; ?>" <?= $resultado['Id_SATCNH'] == $linha['id'] ? 'selected' : '' ?>><?= $linha["categoria"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
           
           
                <div class="row">
    <div class="col">
        <label for="email">Email</label>
        <?php

            $pmm = $resultado['id'];
        try {
            // Consulta para obter o e-mail do usuário
            $comandoSQL3 = "
                SELECT email 
                FROM email
                WHERE id_pm = :id_pm";

            $stmt2 = $conexao->prepare($comandoSQL3);
            $stmt2->execute(['id_pm' => $pmm]); // Passa o ID do usuário
            $emailSalvo = $stmt2->fetchColumn(); // Obtém o e-mail salvo

        } catch (PDOException $erro) {
            echo "Erro ao buscar o e-mail!";
        }
        ?>
        <input
            type="email"
            name="email"
            id="email"
            value="<?= $emailSalvo; ?>"
            placeholder="<?= $emailSalvo; ?>"  
            onblur="validarDados('email',document.getElementById('email').value)"
            required>
    </div>
</div>

            </div>
        </div>
    </form>

    <script src="scripts/steps.js" defer></script>
    <script src="scripts/foto.js" defer></script>
    <script src="scripts/mascaras.js" defer></script>
    <script src="ajax/validacao.js" defer></script>
</body>

</html>