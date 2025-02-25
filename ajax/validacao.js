// Variável que receberá o objeto XMLHttpRequest
function validarDados(campo, valor) {
    let req;
    // Verificar o Browser
    // Firefox, Google Chrome, Safari e outros
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
    }
    // Internet Explorer
    else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }
    // Aqui vai o valor e o nome do campo que pediu a requisição.
    var url = "ajax/validacao.php?campo=" + campo + "&valor=" + valor;
    // Chamada do método open para processar a requisição
    req.open("Get", url, true);
    // Quando o objeto recebe o retorno, chamamos a seguinte função;
    req.onreadystatechange = function () {
        // Exibe a mensagem "Verificando" enquanto carrega
        if (req.readyState == 1) {
            document.getElementById('campo_' + campo + '').innerHTML = '<font color="gray">Verificando...</font>';
        }
        // Verifica se o Ajax realizou todas as operações corretamente (essencial)
        if (req.readyState == 4 && req.status == 200) {
            // Resposta retornada pelo validacao.php
            let resposta = req.responseText;

            // Abaixo colocamos a resposta na div do campo que fez a requisição
            document.getElementById('campo_' + campo + '').innerHTML = resposta;
        }
    }
    req.send(null);
}



// function verificaremail() {

//     var email = document.getElementById('email1');
//     var emai2 = document.getElementById('email1');
// }