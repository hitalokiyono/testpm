<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Inicial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/inicial.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<?php



session_start();



require_once("./conexao/conexao.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["id_atual"])) {
    echo "Usuário não autenticado.";
    exit;
}

$idUsuario = $_SESSION["id_atual"];

// Consulta para buscar os agendamentos onde o e-mail ainda não foi recebido (recebida = 0)
$sql = "SELECT da.Data, a.nome, a.descricao, e.email, da.id_dataagendamento, da.entregue
        FROM data_agendamento da
        JOIN agendamentos a ON da.tipo_agendamento = a.id_agenda
        JOIN email e ON da.id_pm = e.id_pm
        JOIN p1 u ON da.id_pm = u.id
        WHERE da.recebida = 0 AND da.id_pm = :idUsuario";

$stmt = $conexao->prepare($sql);
$stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();

$agendamentosPendentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($agendamentosPendentes)) {
    // Exibe o popup apenas para os agendamentos onde o e-mail ainda não foi recebido
    echo "<div id='popup'>
           
            <h2 style='color: black;'>Agendamentos Pendentes</h2>
            <ul>";
    
    // Configura PHPMailer para envio de e-mails
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'testcontrolelocalhost@gmail.com'; 
    $mail->Password = 'oqjdtulrectwbqlo';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';
    $mail->setFrom('testcontrolelocalhost@gmail.com', 'Agendamentos Pendentes');

    try {
        foreach ($agendamentosPendentes as $agendamento) {
            $idAgendamento = $agendamento['id_dataagendamento'];
            $data = $agendamento['Data'];
            $nome = $agendamento['nome'];
            $descricao = mb_strimwidth($agendamento['descricao'], 0, 55, "...");
            $emailRecuperacao = $agendamento['email'];
            $entregue = $agendamento['entregue'];

            echo "<li>Compromissos pendentes: {$nome} - Data: {$data}</li>
                  <li>Descrição: {$descricao}</li><br>";

            // Exibe o popup apenas se o e-mail ainda não foi recebido
            if ($entregue == 0) {
                // Configura e-mail individual
                $mail->clearAddresses(); // Limpa endereços anteriores
                $mail->addAddress($emailRecuperacao, 'Destinatário');
                $mail->isHTML(true);
                $mail->Subject = "Novo agendamento pendente: {$nome}";
                $mail->Body = "Você tem um novo agendamento pendente:<br>
                               <strong>Nome:</strong> {$nome}<br>
                               <strong>Data:</strong> {$data}<br>
                               <strong>Descrição:</strong> {$descricao}<br>";

                // Envia o e-mail e, se bem-sucedido, atualiza o status
                if ($mail->send()) {
                    // Atualiza o status de 'entregue' para 1 após enviar o e-mail
                    $updateSql = "UPDATE data_agendamento SET entregue = 1 WHERE id_dataagendamento = :idAgendamento";
                    $updateStmt = $conexao->prepare($updateSql);
                    $updateStmt->bindParam(':idAgendamento', $idAgendamento, PDO::PARAM_INT);
                    $updateStmt->execute();
                }
            }
        }
        echo "</ul>
              <button onclick='fecharPopup()'>Fechar</button>
              </div>";

    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}
?>

<style>
#popup,#popupemail{
    position: fixed;
    top: 1%;
    left: 20%;
    transform: translateX(-50%);
    background-color:rgb(255, 255, 255);
    color: #721c24;
    padding: 40px;
    border: 5px solid #f5c6cb;
    border-radius: 10px;
    z-index: 1000;
    width: 500px;
    text-align: center;
}
#popupemail{
    position: fixed;
    left: 80%;
    transform: translateX(-50%);
    background-color:rgb(255, 255, 255);
    color:rgb(0, 0, 0);
    text-align: auto;
    width: 400px;
}


button {
    background-color:rgb(0, 0, 0);
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 10px;
}
</style>

<script>
 let interval = setInterval(checkNewEmails, 3000);  // Verifica a cada 5 segundos

        function checkNewEmails() {
            $.ajax({
                url: './check_emails.php', // Arquivo PHP que retorna e-mails em JSON
                type: 'GET',
                success: function (response) {
                    const data = JSON.parse(response); // Parseia a resposta JSON

                    // Verifica se há novos e-mails
                    if (data.new_emails > 0) {
                        $('#email-list').empty(); // Limpa a lista de e-mails

                        data.emails.forEach(function (email) {
                            $('#email-list').append(`
    <li>
        <strong>Assunto:</strong> ${email.subject} <br>
        <strong>De:</strong> ${email.from} <br>
        <strong>Data:</strong> ${email.date} <br>
        <strong>Nome:</strong> ${email.nome} <br>
        <strong>RE:</strong> ${email.re} <br><br>
    </li>
`);
                        });

                        $('#popupemail').fadeIn(); // Exibe o popup
                    }
                },
                error: function () {
                    console.error('Erro ao verificar novos e-mails.');
                }
            });
        }

        function fecharPopup() {
            $('#popup').fadeOut();
        }
        function fecharPopup2() {
            $('#popupemail').fadeOut();
        }

function closeNotification() {
    $("#notificacao").hide();
}

function fecharPopup() {
    document.getElementById('popup').style.display = 'none';
}

function fecharPopup2() {
    document.getElementById('popupemail').style.display = 'none';
}

</script>

<body>
    <div class="menuicon">
        <div class="titulo-login">
            <h1>ADM QRV - 2º BPM/I - 1ª CIA</h1>
        </div>
        <div class="img"></div>

        <ul>
            <?php
            if (!isset($_SESSION)) {
                session_start();
            }

            if ($_SESSION['permissao'] == 0) {
             echo '<li><a href="./usuariovisualizacao.php"><i class="fas fa-search"></i> VISUALIZAR</a></li>';
               echo '<li><a href="./p4/consultarpm.php"><i class="fas fa-clipboard-list"></i> consultar itens em romaneio</a></li>';
                echo '<li><a href="./cadastrocursomenu.php"><i class="fas fa-book"></i> VISUALIZAR CURSO</a></li>';
                echo '<li><a href="./visualizarfilhomenu.php"><i class="fas fa-child"></i> VISUALIZAR FILHO</a></li>';
        
            } else if ($_SESSION['permissao'] > 0 && $_SESSION['permissao'] < 4) {
                echo '<li><a href="./visualizacao.php"><i class="fas fa-search"></i> VISUALIZAR</a></li>';
                echo '<li><a href="./cadastrocursomenu.php"><i class="fas fa-book"></i> VISUALIZAR CURSO</a></li>';
                echo '<li><a href="./visualizarfilhomenu.php"><i class="fas fa-child"></i> VISUALIZAR FILHO</a></li>';
                echo '<li><a href="mailto:testcontrolelocalhost@gmail.com?subject=Comunicação com o Administrador" target="_blank"><i class="fas fa-paper-plane"></i> COMUNICAR ADMINISTRADOR</a></li>';
            }
            
            
            else if ($_SESSION['permissao'] >= 4 ) {
                echo '<li><a href="./email.php"><i class="fas fa-user-plus"></i> CADASTRAR</a></li>';
                echo '<li><a href="./cadastrocursomenu.php"><i class="fas fa-clipboard-list"></i> VISUALIZAR CURSO</a></li>';
                echo '<li><a href="./visualizarfilhomenu.php"><i class="fas fa-child"></i> VISUALIZAR FILHO</a></li>';
                echo '<li><a href="https://mail.google.com/mail/u/0/#inbox"><i class="fas fa-envelope-open-text"></i>Email</a></li>';
                echo '<li><a href="./visualizacao.php"><i class="fas fa-eye"></i> VISUALIZAR</a></li>';
                echo '<li><a href="./p4/estoque.php"><i class="fas fa-warehouse"></i> ESTOQUE</a></li>';
             echo'<li><a href="./p4/motomecmenu.php"><i class="fas fa-car"></i> MOTOMEC</a></li>';
             echo '<li><a href="./p4/romaneiomenu.php"><i class="fas fa-list"></i> Alocação</a></li>';
            }
            ?>
            <li><a href="./agenda.php"><i class="fas fa-calendar-alt"></i> AGENDA</a></li>
            <li><a href="./sair.php"><i class="fas fa-sign-out-alt"></i> SAIR</a></li>
        </ul>
    </div>

    <div id="popupemail" style="display: none;">
        <h2>Notificação de E-mails</h2>
        <ul id="email-list"></ul>
        <button onclick="fecharPopup2()">Fechar</button>
    </div>
</body>

</html>
