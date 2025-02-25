<?php

require 'vendor/autoload.php';


$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';  
$username = 'testcontrolelocalhost@gmail.com';      
$password = 'oqjdtulrectwbqlo';                    

$inbox = imap_open($hostname, $username, $password);

if (!$inbox) {
    echo json_encode(['error' => 'Erro de conexão: ' . imap_last_error()]);
    exit();
}

// Verificar a caixa de entrada
$check = imap_check($inbox);
if (!$check) {
    // Se imap_check falhar, retorna um erro
    echo json_encode(['error' => 'Erro ao verificar a caixa de entrada: ' . imap_last_error()]);
    exit();
}

// Buscar e-mails não lidos (status "UNSEEN")
$emails = imap_search($inbox, 'UNSEEN');
$response = [];

if ($emails) {
    // Se houver e-mails não lidos, retorna a quantidade e os detalhes
    $response['new_emails'] = count($emails);
    $response['emails'] = [];

    foreach ($emails as $email_num) {
        $overview = imap_fetch_overview($inbox, $email_num, 0);
        if ($overview) {
            // Extrair informações do e-mail
            $email = [
                'subject' => htmlspecialchars($overview[0]->subject),
                'from' => htmlspecialchars($overview[0]->from),
                'date' => htmlspecialchars($overview[0]->date),
                'uid' => htmlspecialchars($overview[0]->uid),
                'message' => nl2br(htmlspecialchars(imap_fetchbody($inbox, $email_num, 1)))  // Corpo do e-mail
            ];

   $email_from = $email['from'];
            
   $email_from = $email['from'];

   // Usando regex para capturar o e-mail dentro de <>
   preg_match('/<([^>]+)>/', $email_from, $matches);
   
   // Verifica se a regex encontrou o e-mail dentro de <>
   if (isset($matches[1])) {
       $email_address = $matches[1];  // O endereço de e-mail extraído
   } else {
       preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $email_from, $matches);
       if (isset($matches[0])) {
           $email_address = $matches[0];  // O e-mail extraído diretamente
       } else {
           $email_address = $email_from;  // Caso não encontre, usa o valor original
       }
   }
   
            require_once("./conexao/conexao.php");

            // Prepara a consulta SQL para buscar as informações de NomeCompleto e RE baseados no e-mail
            $verificaPermissao = $conexao->prepare("SELECT p1.NomeCompleto, p1.RE
                FROM p1 
                INNER JOIN email ON email.id_pm = p1.id
                WHERE email.email = :email;");
            
            $verificaPermissao->execute(array(":email" => $email_address));

            // Verificar se a consulta retornou algum dado
            if ($permissao = $verificaPermissao->fetch(PDO::FETCH_ASSOC)) {
                

                $email['nome'] = htmlspecialchars($permissao['NomeCompleto']);
                $email['re'] = htmlspecialchars($permissao['RE']);
            } else {
                // Caso não encontre os dados, você pode definir valores padrão
                $email['nome'] = $email_address ;
                $email['re'] = 'RE não encontrado';
            }

            // Adiciona o e-mail à lista de respostas
            $response['emails'][] = $email;
        }
    }
} else {
    $response['new_emails'] = 0;
}

imap_close($inbox);

echo json_encode($response);
?>
