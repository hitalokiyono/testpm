
<?php
if (isset($_GET['email'])) {
    $email = $_GET['email'];
    
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['email'] = $email;


    var_dump($_SESSION['email']);

    echo "E-mail $email validado com sucesso!";
} else {
    echo "E-mail não fornecido!";
}
?>
