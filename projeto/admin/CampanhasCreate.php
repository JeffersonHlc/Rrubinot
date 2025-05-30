<?php
session_start();
require_once '../conexao.php';
require_once '../classes/Campanha.php';
require_once '../classes/CampanhaDao.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_perfil'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Criar Nova Campanha</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
<section>
    <div>
        <h2>Criar Nova Campanha</h2>

        <?php
        if (isset($_SESSION['erro'])) {
            echo '<p class="erro-campo">' . $_SESSION['erro'] . '</p>';
            unset($_SESSION['erro']);
        }
        if (isset($_SESSION['sucesso'])) {
            echo '<p class="sucesso-geral">' . $_SESSION['sucesso'] . '</p>';
            unset($_SESSION['sucesso']);
        }
        ?>

        <form action="SalvarCampanha.php" method="post">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" rows="4" required></textarea>

            <label for="item_premio">Item do jogo (prêmio):</label>
            <input type="text" name="item_premio" id="item_premio" required>

            <label for="valor_por_titulo">Valor por título (R$):</label>
            <input type="number" name="valor_por_titulo" id="valor_por_titulo" step="0.01" min="0" required>

            <label for="data_inicio">Data de início:</label>
            <input type="datetime-local" name="data_inicio" id="data_inicio" required>

            <label for="data_fim">Data de fim:</label>
            <input type="datetime-local" name="data_fim" id="data_fim" required>

            <label for="total_titulos">Total de títulos:</label>
            <input type="number" name="total_titulos" id="total_titulos" min="1" value="10000" required>

            <input type="submit" value="Criar Campanha">
        </form>

        <p><a href="CampanhasList.php">Voltar para lista</a></p>
    </div>
</section>
</body>
</html>