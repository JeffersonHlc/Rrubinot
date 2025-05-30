<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function exibirErroCampo($campo) {
    if (isset($_SESSION["erro_$campo"])) {
        echo '<p class="erro-campo">' . $_SESSION["erro_$campo"] . '</p>';
        unset($_SESSION["erro_$campo"]);
    }
}

if (isset($_SESSION['sucesso'])) {
    echo '<p class="sucesso-geral">' . $_SESSION['sucesso'] . '</p>';
    unset($_SESSION['sucesso']);
}

if (isset($_SESSION['erro_login'])) {
    echo '<p class="erro-campo">' . $_SESSION['erro_login'] . '</p>';
    unset($_SESSION['erro_login']);
}
?>


