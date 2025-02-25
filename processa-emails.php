<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emailRecuperacao = $_POST['email2'];

    // Instância da classe PHPMailer
    $mail = new PHPMailer(true);

    // Ativa o debug SMTP detalhado
    $mail->SMTPDebug = 2;

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP(); 
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'testcontrolelocalhost@gmail.com'; // Seu e-mail do Gmail
        $mail->Password = 'oqjdtulrectwbqlo'; // Senha de aplicativo gerada
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuração do e-mail
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('testcontrolelocalhost@gmail.com', 'test de agendamaneto');
        $mail->addAddress($emailRecuperacao, 'Destinatário');
        $mail->isHTML(true);
        $mail->Subject = 'Confirmar e-mail QRV - 2º BPM/I - 1ª CIA';
        
        // Link de autenticação (simulação)
        $linkAutenticacao = 'http://localhost/controlethiago/verificar.php?email=' . urlencode($emailRecuperacao);

        $mail->Body = 'Clique no link abaixo para confirmar seu e-mail de recuperação:<br><a href="' . $linkAutenticacao . '">Confirmar E-mail</a>';

        // Envia o e-mail
        $mail->send();
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['email'] = $emailRecuperacao;

        header("location:./cadastro.php");
        exit();
    
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}
?>
