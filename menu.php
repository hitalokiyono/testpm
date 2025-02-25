<div class="menu">
    <ul>
        <?php
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($_SESSION['permissao']  === 5) {
            echo '<a href="./email.php"><li>CADASTRAR</li></a>';
            echo '<a href="./visualizacao.php"><li>VISUALIZAR</li></a>';
            echo '<a href="./visualizacao.php"><li>PERMISSÕES</li></a>';
        }
        ?>
        <a href="./inicial.php">
            <li>MENU</li>
        </a>
        <a href="./agenda.php">
            <li>AGENDA</li>
        </a>
        <a href="./sair.php">
            <li>SAIR</li>
        </a>
    </ul>
</div>