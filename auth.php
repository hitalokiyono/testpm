<?php
require_once 'vendor/autoload.php';

// Inicie o cliente OAuth
$client = new Google_Client();
$client->setClientId('750916723733-1ap99loaepga8k0m7sq1qp0p628jeo2d.apps.googleusercontent.com'); // Substitua pelo seu Client ID
$client->setClientSecret('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'); // Substitua pelo seu Client Secret
$client->setRedirectUri('http://localhost/controlethiago/callback.php'); // Substitua pela sua URI de redirecionamento
$client->addScope(Google_Service_Gmail::GMAIL_READONLY);

// Verifique se já existe um token de acesso na sessão
session_start();
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    // Se o token de acesso já estiver na sessão, use-o para autorizar o cliente
    $client->setAccessToken($_SESSION['access_token']);
    
    // Verifique se o token ainda é válido
    if ($client->isAccessTokenExpired()) {
        // Se o token tiver expirado, remova da sessão e redirecione o usuário para a autenticação
        unset($_SESSION['access_token']);
        header('Location: ' . $client->createAuthUrl());
        exit;
    }
} else {
    // Se o token não estiver na sessão, redireciona o usuário para a página de login
    if (!isset($_GET['code'])) {
        // Se não houver código de autenticação, redireciona para o Google para autenticar
        $authUrl = $client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit;
    } else {
        // Se o código de autenticação estiver presente, troque-o por um token de acesso
        $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        // Armazene o token de acesso na sessão
        $_SESSION['access_token'] = $accessToken;
        
        // Redirecione o usuário de volta para a página principal (ou outra página após a autenticação)
        header('Location: ' . filter_var('http://localhost/controlethiago/', FILTER_SANITIZE_URL));
        exit;
    }
}

// Agora, você pode usar o cliente autenticado para fazer chamadas à API
$service = new Google_Service_Gmail($client);
// Exemplos de chamadas à API (como listar mensagens):
$messages = $service->users_messages->listUsersMessages('me');
foreach ($messages as $message) {
    echo "Message ID: " . $message->getId() . "<br>";
}
?>
