<?php
session_start();
if (!isset($_SESSION["id_atual"]))
     header("location:./index.php")
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilo.css">
    <title>Controle Policia Militar :: Cadastro</title>

</head>

<body>
    <?php
if (!isset($_SESSION["id_atual"])) {
    $_SESSION['permissao'] = 0;
    require_once("./menu.php");
} else {

    require_once("./consultapermissao.php");

    if ($_SESSION['permissao'] > 0) {
        require_once("./menu.php");
    }
}
    ?>
    <h1 class="titulo">Cadastro</h1>


    <form action="cadastrobd.php" method="post" enctype="multipart/form-data">
        <div class="imagem">
            <label for="foto" style="cursor:pointer;">
                <img id='thumb' src="./img/usuario.png" alt="imagem de perfil">
            </label>
            <input type="file" name="foto" id="foto" accept="image/*">
        </div>
        <div class="step active" id="step-1">
            <h2 class="titulo">Dados pessoais</h2>
            <div class="container">
                <div class="container-form">
                    <div class="row">
                        <div class="col">
                            <label for="nome">Nome Completo <span class="validacao0" id="campo_nome"></span></label>
                            <div id="campo_nome"></div>
                            <input type="text" name="nome" id="nome" onblur="validarDados('nome',document.getElementById('nome').value)" placeholder="Nome completo do policial." required>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="cpf">CPF <span class="validacao0" id="campo_cpf"></span></label>
                            <input type="text" name="cpf" id="cpf" oninput="mascaraCPF(this)" maxlength="14" onblur="validarDados('cpf',document.getElementById('cpf').value)" placeholder="Ex: xxx.xxx.xxx-xx" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="rg">RG<span class="validacao0" id="campo_rg"></span></label>
                            <input type="text" name="rg" id="rg" onblur="validarDados('rg',document.getElementById('rg').value)" oninput="mascaraRG(this)" placeholder="RG do policial." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="data_nascimento">Data de nascimento<span class="validacao0" id="campo_data_nascimento"></span></label>
                            <input type="date" name="data_nascimento" id="data_nascimento" onblur="validarDados('data_nascimento',document.getElementById('data_nascimento').value)" placeholder="Data de nascimento." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="sexo_policial">Sexo<span class="validacao0" id="campo_sexo_policial"></span></label>

                            <!-- conectar com o banco fazer o select -->
                            <?php
                            require_once("./conexao/conexao.php");

                            try {
                                $comandoSQL = "SELECT * FROM sexo";

                                // Executa o comandoSQL no banco QUERY
                                $dadosSelecionados = $conexao->query($comandoSQL);

                                // Coloca os dados em formato de matriz / Excel
                                $dados = $dadosSelecionados->fetchAll();
                            } catch (PDOException $erro) {
                                echo ("Entre em contato com o suporte!");
                            }
                            ?>
                            <select name="sexo_policial" id="sexo_policial" onblur="validarDados('sexo_policial',document.getElementById('sexo_policial').value)" required>]
                                <option value="">Selecione as opções</option>
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
                            <label for="cnh">CNH<span class="validacao0" id="campo_cnh"></span></label>
                            <input type="text" name="cnh" id="cnh" maxlength="11" placeholder="CNH do policial." required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="categoria_cnh">Categoria CNH<span class="validacao0" id="campo_categoriacnh"></span></label>

                            <!-- conectar com o banco fazer o select -->
                            <?php
                            require_once("./conexao/conexao.php");

                            try {
                                $comandoSQL = "SELECT * FROM categoriacnh";

                                // Executa o comandoSQL no banco QUERY
                                $dadosSelecionados = $conexao->query($comandoSQL);

                                // Coloca os dados em formato de matriz / Excel
                                $dados = $dadosSelecionados->fetchAll();
                            } catch (PDOException $erro) {
                                echo ("Entre em contato com o suporte!");
                            }
                            ?>
                            <select name="categoriacnh" id="categoriacnh" onblur="validarDados('categoriacnh',document.getElementById('categoriacnh').value)" required>
                                <option value="">Selecione a categoria da CNH</option>
                                <?php
                                foreach ($dados as $linha) {
                                ?>
                                    <option value="<?= $linha['id']; ?>"><?= $linha["categoria"]; ?></option>
                                <?php
                                }
                                ?>

                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="validade">Validade CNH<span class="validacao0" id="campo_validade"></span></label>
                            <input type="date" name="validade" id="validade" onblur="validarDados('validade',document.getElementById('validade').value)" placeholder="Validade da CNH." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="nome_pai">Nome do pai<span class="validacao0" id="campo_nome_pai"></span></label>
                            <input type="text" name="nome_pai" id="nome_pai" onblur="validarDados('nome_pai',document.getElementById('nome_pai').value)" placeholder="Nome do pai." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="nome_mae">Nome da mãe<span class="validacao0" id="campo_nome_mae"></span></label>
                            <input type="text" name="nome_mae" id="nome_mae" onblur="validarDados('nome_mae',document.getElementById('nome_mae').value)" placeholder="Nome da mãe." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="estado_civil">Estado civil<span class="validacao0" id="campo_estadocivil"></span></label>

                            <!-- conectar com o banco fazer o select -->
                            <?php
                            require_once("./conexao/conexao.php");

                            try {
                                $comandoSQL = "SELECT * FROM estadocivil";

                                // Executa o comandoSQL no banco QUERY
                                $dadosSelecionados = $conexao->query($comandoSQL);

                                // Coloca os dados em formato de matriz / Excel
                                $dados = $dadosSelecionados->fetchAll();
                            } catch (PDOException $erro) {
                                echo ("Entre em contato com o suporte!");
                            }
                            ?>
                            <select name="estadocivil" id="estadocivil" onblur="validarDados('estadocivil',document.getElementById('estadocivil').value)" required>
                                <option value="">Selecione as opções</option>
                                <?php
                                foreach ($dados as $linha) {
                                ?>
                                    <option value="<?= $linha['id']; ?>"><?= $linha["estado"]; ?></option>
                                <?php
                                }
                                ?>

                            </select>

                        </div>
                    </div>
                </div>
            </div>
            <div class="container-buttom">
                <div class="row">
                    <div class="col">
                        <input type="button" value="PRÓXIMO">
                    </div>
                </div>
            </div>
        </div>

        <div class="step" id="step-2">
            <h2 class="titulo">Dados de Contato</h2>
            <div class="container">
                <div class="container-form">
                    <div class="row">
                        <div class="col">
                            <label for="cep">CEP<span class="validacao1" id="campo_cep"></span></label>
                            <input type="text" name="cep" id="cep" onblur="buscarCEP(this.value)" oninput="mascaraCEP(this)" maxlength="9" placeholder="Digite seu CEP" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="endereco">Endereço<span class="validacao1" id="campo_endereco"></span></label>
                            <input type="text" name="endereco" id="endereco" onblur="validarDados('endereco',document.getElementById('endereco').value)" placeholder="Endereço." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="numero">Numero<span class="validacao1" id="campo_numero"></span></label>
                            <input type="text" name="numero" id="numero" onblur="validarDados('numero',document.getElementById('numero').value)" placeholder="Numero." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="endereco">Bairro<span class="validacao1" id="campo_bairro"></span></label>
                            <input type="text" name="bairro" id="bairro" onblur="validarDados('bairro',document.getElementById('bairro').value)" placeholder="Bairro." required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="cidade">Cidade Atual<span class="validacao1" id="campo_cidade"></span></label>
                            <?php
                            require_once("./conexao/conexao.php");
                            try {
                                $comandoSQL = "SELECT id, nome FROM cidades";
                                // Executa o comandoSQL no banco QUERY
                                $dadosSelecionados = $conexao->query($comandoSQL);
                                // Coloca os dados em formato de matriz / Excel
                                $dados = $dadosSelecionados->fetchAll();
                            } catch (PDOException $erro) {
                                echo ("Entre em contato com o suporte!");
                            }
                            ?>
                            <input name="cidadeId" id="cidadeId" type="hidden" />
                            <input list="cidadelist" name="cidade" id="cidade" onblur="validarDados('cidade',document.getElementById('cidade').value)" />
                            <datalist id="cidadelist">
                                <option value="Selecione as opções"></option>
                                <?php
                                foreach ($dados as $linha) {
                                ?>
                                    <option data-id="<?= $linha['id']; ?>" value="<?= $linha['nome']; ?>"></option>
                                <?php
                                }
                                ?>
                            </datalist>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="uf">UF Atual<span class="validacao1" id="campo_uf"></span></label>

                            <!-- conectar com o banco fazer o select -->
                            <?php
                            require_once("./conexao/conexao.php");

                            try {
                                $comandoSQL = "SELECT * FROM estados";

                                // Executa o comandoSQL no banco QUERY
                                $dadosSelecionados = $conexao->query($comandoSQL);

                                // Coloca os dados em formato de matriz / Excel
                                $dados = $dadosSelecionados->fetchAll();
                            } catch (PDOException $erro) {
                                echo ("Entre em contato com o suporte!");
                            }
                            ?>

                            <!-- Mudando o select para datalist -->
                            <select name="uf" id="uf" onblur="validarDados('uf', document.getElementById('uf').value)">
                                <option value="">Selecione o estado</option>
                                <?php
                                foreach ($dados as $linha) {
                                ?>
                                    <option value="<?= $linha['id']; ?>"><?= $linha['uf']; ?></option>
                                <?php
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="cep">Complemento</label>
                            <input type="text" name="complemento" id="complemento" placeholder="Ex: Bloco 800 apt 665">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="telefone">Celular 1<span class="validacao1" id="campo_telefone1"></span></label>
                            <input type="text" name="telefone1" id="telefone1" onblur="validarDados('telefone1',document.getElementById('telefone1').value)" oninput="mascaraTelefone(this)" maxlength="15" placeholder="Digite seu celular xx xxxxx-xxxx." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="celular2">Celular 2</label>
                            <input type="text" name="celular2" id="celular2" onblur="validarDados('celular2',document.getElementById('celular2').value)" oninput="mascaraTelefone(this)" maxlength="15" placeholder="Celular 2 opcional.">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="celular_Recado">Celular de Recado<span class="validacao1" id="campo_celular_Recado"></span></label>
                            <input type="text" name="celular_Recado" id="celular_Recado" onblur="validarDados('celular_Recado',document.getElementById('celular_Recado').value)" oninput="mascaraTelefone(this)" maxlength="15" placeholder="Digite seu celular xx xxxxx-xxxx.">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="nome_conjuge">Nome do cônjuge<span class="validacao1" id="campo_nome_conjuge"></span></label>
                            <input type="text" name="nome_conjuge" id="nome_conjuge" onblur="validarDados('nome_conjuge',document.getElementById('nome_conjuge').value)" placeholder="Nome do cônjuge.">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="data_nascimento">Data de nascimento cônjuge<span class="validacao1" id="campo_data_nascimento_conjuge"></span></label>
                            <input type="date" name="data_nascimento_conjuge" id="data_nascimento_conjuge" onblur="validarDados('data_nascimento_conjuge',document.getElementById('data_nascimento_conjuge').value)" placeholder="Data de nascimento do conjuge.">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="cidade">Cidade Natal<span class="validacao1" id="campo_cidadenatal"></span></label>

                            <!-- conectar com o banco fazer o select -->
                            <?php
                            require_once("./conexao/conexao.php");

                            try {
                                $comandoSQL = "SELECT * FROM cidades";

                                // Executa o comandoSQL no banco QUERY
                                $dadosSelecionados = $conexao->query($comandoSQL);

                                // Coloca os dados em formato de matriz / Excel
                                $dados = $dadosSelecionados->fetchAll();
                            } catch (PDOException $erro) {
                                echo ("Entre em contato com o suporte!");
                            }
                            ?>
                            <input name="cidadenatalId" id="cidadenatalId" type="hidden" />
                            <input list="cidadelistnatal" name="cidadenatal" id="cidadenatal" onblur="validarDados('cidadenatal',document.getElementById('cidadenatal').value)" />
                            <datalist id="cidadelistnatal">
                                <option value="Selecione as opções"></option>
                                <?php
                                foreach ($dados as $linha) {
                                ?>
                                    <option data-id="<?= $linha['id']; ?>" value="<?= $linha['nome']; ?>"></option>
                                <?php
                                }
                                ?>
                            </datalist>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="uf">UF Natal<span class="validacao1" id="campo_ufnatal"></span></label>

                            <!-- conectar com o banco fazer o select -->
                            <?php
                            require_once("./conexao/conexao.php");

                            try {
                                $comandoSQL = "SELECT * FROM estados";

                                // Executa o comandoSQL no banco QUERY
                                $dadosSelecionados = $conexao->query($comandoSQL);

                                // Coloca os dados em formato de matriz / Excel
                                $dados = $dadosSelecionados->fetchAll();
                            } catch (PDOException $erro) {
                                echo ("Entre em contato com o suporte!");
                            }
                            ?>
                            <!--select -->
                            <select name="ufnatal" id="ufnatal" onblur="validarDados('ufnatal', document.getElementById('ufnatal').value)">
                                <option value="">Selecione o estado</option>
                                <?php
                                foreach ($dados as $linha) {
                                ?>
                                    <option value="<?= $linha['id']; ?>"><?= $linha['uf']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-buttom">
                <div class="row">
                    <div class="col">
                        <button class="voltar-btn">VOLTAR</button>
                        <input type="button" value="PRÓXIMO">

                    </div>
                </div>
            </div>
        </div>

        <div class="step" id="step-3">
            <h2 class="titulo">Dados Funcionais</h2>
            <div class="container">
                <div class="container-form">
                    <div class="row">
                        <div class="col">
                            <label for="re">RE<span class="validacao2" id="campo_re"></span></label>
                            <input type="text" name="re" id="re" onblur="validarDados('re',document.getElementById('re').value)" oninput="mascaraRE(this)" placeholder="Digite o seu RE." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="posto">Posto/Graduação<span class="validacao2" id="campo_posto"></span></label>
                            <!-- conectar com o banco fazer o select -->
                            <?php
                            require_once("./conexao/conexao.php");

                            try {
                                $comandoSQL = "SELECT * FROM graduacao";

                                // Executa o comandoSQL no banco QUERY
                                $dadosSelecionados = $conexao->query($comandoSQL);

                                // Coloca os dados em formato de matriz / Excel
                                $dados = $dadosSelecionados->fetchAll();
                            } catch (PDOException $erro) {
                                echo ("Entre em contato com o suporte!");
                            }
                            ?>
                            <select name="posto" id="posto" onblur="validarDados('posto',document.getElementById('posto').value)" required>
                                <option value="">Selecione as opções</option>
                                <?php
                                foreach ($dados as $linha) {
                                ?>
                                    <option value="<?= $linha['id']; ?>"><?= $linha["posto"]; ?></option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="nome_de_guerra">Nome de guerra<span class="validacao2" id="campo_nome_de_guerra"></span></label>
                            <input type="text" name="nome_de_guerra" id="nome_de_guerra" onblur="validarDados('nome_de_guerra',document.getElementById('nome_de_guerra').value)" placeholder="Nome de guerra." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="data_apresentacao">Data de apresentação<span class="validacao2" id="campo_data_apresentacao"></span></label>
                            <input type="date" name="data_apresentacao" id="data_apresentacao" onblur="validarDados('data_apresentacao',document.getElementById('data_apresentacao').value)" placeholder="Data de Admissão." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="data_admissao">Data de Admissão<span class="validacao2" id="campo_data_admissao"></span></label>
                            <input type="date" name="data_admissao" id="data_admissao" onblur="validarDados('data_admissao',document.getElementById('data_admissao').value)" placeholder="Data de Admissão." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="tipo_sanguineo">Tipo sanguíneo<span class="validacao2" id="campo_tiposanguineo"></span></label>

                            <!-- conectar com o banco fazer o select -->
                            <?php
                            require_once("./conexao/conexao.php");

                            try {
                                $comandoSQL = "SELECT * FROM tiposanguineo";

                                // Executa o comandoSQL no banco QUERY
                                $dadosSelecionados = $conexao->query($comandoSQL);

                                // Coloca os dados em formato de matriz / Excel
                                $dados = $dadosSelecionados->fetchAll();
                            } catch (PDOException $erro) {
                                echo ("Entre em contato com o suporte!");
                            }
                            ?>
                            <select name="tiposanguineo" id="tiposanguineo" onblur="validarDados('tiposanguineo',document.getElementById('tiposanguineo').value)" required>
                                <option value="">Selecione as opções</option>
                                <?php
                                foreach ($dados as $linha) {
                                ?>
                                    <option value="<?= $linha['id']; ?>"><?= $linha["tipo"]; ?></option>
                                <?php
                                }
                                ?>

                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="categoria_cnh">CAT/SAT<span class="validacao2" id="campo_categoria_cnh"></span></label>

                            <!-- conectar com o banco fazer o select -->
                            <?php
                            require_once("./conexao/conexao.php");

                            try {
                                $comandoSQL = "SELECT * FROM categoriacnh";

                                // Executa o comandoSQL no banco QUERY
                                $dadosSelecionados = $conexao->query($comandoSQL);

                                // Coloca os dados em formato de matriz / Excel
                                $dados = $dadosSelecionados->fetchAll();
                            } catch (PDOException $erro) {
                                echo ("Entre em contato com o suporte!");
                            }
                            ?>
                            <select name="categoria_cnh" id="categoria_cnh" onblur="validarDados('categoria_cnh',document.getElementById('categoria_cnh').value)" required>
                                <option value="">Selecione as opções</option>
                                <?php
                                foreach ($dados as $linha) {
                                ?>
                                    <option value="<?= $linha['id']; ?>"><?= $linha["categoria"]; ?></option>
                                <?php
                                }
                                ?>

                            </select>

                        </div>
                    </div>
                </div>
            </div>
            <div class="container-buttom">
                <div class="row">
                    <div class="col">
                        <button class="voltar-btn">VOLTAR</button>
                        <input type="submit" value="SALVAR" onclick="atualizarIdCidade()">
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>

    <script src="scripts/steps.js" defer></script>
    <script src="scripts/foto.js" defer></script>
    <script src="scripts/mascaras.js" defer></script>
    <script src="ajax/validacao.js" defer></script>
    <script src="scripts/buscarCEP.js" defer></script>
    <script>
        function atualizarIdCidade() {
            let inputCidade = document.getElementById("cidade");
            let lista = document.getElementById("cidadelist");
            let hidden = document.getElementById("cidadeId");

            let opcaoSelecionada = Array.from(lista.options).find(o => o.value === inputCidade.value);
            hidden.value = opcaoSelecionada ? opcaoSelecionada.getAttribute("data-id") : "";

            let inputCidadenatal = document.getElementById("cidadenatal");
            let listanatal = document.getElementById("cidadelistnatal");
            let hiddennatal = document.getElementById("cidadenatalId");

            let opcaoSelecionadanatal = Array.from(listanatal.options).find(o => o.value === inputCidadenatal.value);
            hiddennatal.value = opcaoSelecionadanatal ? opcaoSelecionadanatal.getAttribute("data-id") : "";
        }
    </script>

</body>

</html>