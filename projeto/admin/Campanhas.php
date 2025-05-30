<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Campanha</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <section>
        <div>
            <h2>Criar Nova Campanha</h2>
            <form action="salvar_campanha.php" method="post">
                <label>Título:</label>
                <input type="text" name="titulo" required>

                <label>Descrição:</label>
                <textarea name="descricao" required></textarea>

                <label>Item do jogo (prêmio):</label>
                <input type="text" name="item" required>

                <label>Valor por número (R$):</label>
                <input type="number" name="valor" step="0.01" required>

                <label>Data de Início:</label>
                <input type="datetime-local" name="inicio" required>

                <label>Data de Fim:</label>
                <input type="datetime-local" name="fim" required>

                <label>Total de Títulos:</label>
                <input type="number" name="total" value="10000" required>

                <input type="submit" value="Criar Campanha">
            </form>
        </div>
    </section>
</body>
</html>
