<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login 2ºBPM/1 - 1ª CIA</title>
    <link rel="stylesheet" href="./css/estilo.css">
    <link rel="manifest" href="./scripts/manifest.json">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="main">
        <div class="conteudo">
            <div class="titulo-login">
                <h1>OASIS - 2º BPM/I - 1ª CIA</h1>
            </div>
            <div class="logo">
                <img id="logo1" src="./img/pm_logo.png" alt="Logo da PM">
                <img id="logo2" src="./img/logo-gov.png" alt="Logo do Governo do estado de SP">
                <img id="logo3" src="./img/fatec.png" alt="Logo fatec">
            </div>

            <div class="pwa" id="pwa" style="display: none;" onclick="fechar();">

                <button id="fechar">x</button>
                <h2> baixe o aplicativo</h2>
                <button id="addToHomeScreen">click aqui </button>

            </div>




            <?php
            if (isset($_GET["status"])) {
                $messages = [
                    "erro-usuario" => "O usuário informado não está cadastrado.",
                    "erro-senha" => "A senha informada não está cadastrada.",
                    "erro-usuario-suporte" => "Entre em contato com o suporte."
                ];
                if (array_key_exists($_GET["status"], $messages)) {
                    echo "<p class='alerta erro'>{$messages[$_GET["status"]]}</p>";
                }
            }
            ?>
            <form action="valida_senha.php" method="POST">
                <div class="row">
                    <div class="col-login">
                        <label for="usuario">RE</label>
                        <input type="text" name="usuario" id="usuario" placeholder="Informe seu RE de acesso!">
                    </div>
                </div>
                <div class="row">
                    <div class="col-login">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" placeholder="Senha com 8 dígitos!">
                    </div>
                </div>
                <div class="btns">
                    <div class="row">
                        <input type="submit" value="L O G A R">
                    </div>
                    <div class="row">
                        <a href="./cadastro.php"><input type="button" value="CADASTRE-SE"></a>
                    </div>
                </div>
            </form>
            <footer class="rodape">
                <div>
                    <b>Desenvolvido por Thiago Matheus Alcebíades Pereira, Hitalo Miguel Caparros Kiyono, Sd PM 160788-0 Ramalho sob orientação de
                        Prof. Me. Alexandre Marcelino da Silva, Prof. Me. Ronnie Marcos Rillo sob supervisão Cap PM 121902-2 Spina.</b>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Variável para armazenar o evento deferredPrompt
        let deferredPrompt;

        // Evento 'beforeinstallprompt' para exibir o botão de instalação
        window.addEventListener('beforeinstallprompt', (event) => {
            console.log('Evento beforeinstallprompt disparado');
            event.preventDefault();
            deferredPrompt = event;

            // Tornar a div PWA visível
            const pwaDiv = document.getElementById('pwa');
            pwaDiv.style.display = 'block';

            // Adicionar evento ao botão para iniciar o prompt de instalação
            const addToHomeScreenButton = document.getElementById('addToHomeScreen');
            addToHomeScreenButton.addEventListener('click', () => {
                console.log('Usuário clicou no botão de adicionar à tela inicial');
                deferredPrompt.prompt();

                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('Usuário aceitou adicionar à tela inicial');
                    } else {
                        console.log('Usuário recusou adicionar à tela inicial');
                    }
                    deferredPrompt = null; // Limpar o evento
                });
            });
        });

        // Evento 'appinstalled' para ocultar a div após instalação
        window.addEventListener('appinstalled', () => {
            console.log('Aplicação foi instalada');
            document.getElementById('pwa').style.display = 'none';
        });

        // Verificar se o Service Worker está ativo
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.ready.then((registration) => {
                console.log('Service Worker ativo e pronto:', registration);
            });
        } else {
            console.log('Service Worker não está disponível neste navegador.');
        }

        // Ocultar mensagens de erro após 3 segundos
        setTimeout(() => {
            const alerta = document.querySelector(".alerta");
            if (alerta) {
                alerta.classList.add('esconder');
            }
        }, 3000);


        function fechar() {

            const pwaDiv = document.getElementById('pwa');
            const fechar = document.getElementById('fechar');


            if (pwaDiv.style.display === "none") {
                pwaDiv.style.display = 'block';
            } else {
                pwaDiv.style.display = 'none';
            }
        }
    </script>
</body>

</html>