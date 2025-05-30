<?php
session_start();
require_once '../conexao.php';
require_once '../classes/Campanha.php';
require_once '../classes/CampanhaDao.php';

if (!isset($_GET['id'])) {
    header("Location: CampanhasList.php");
    exit;
}

$dao = new CampanhaDao($conn);
$id = intval($_GET['id']);
$campanha = $dao->buscarPorId($id);

if (!$campanha) {
    $_SESSION['erro'] = "Campanha não encontrada.";
    header("Location: CampanhasList.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Campanha</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<section>
    <div>
        <h2>Editar Campanha</h2>
        <form action="AtualizarCampanha.php" method="post">
            <input type="hidden" name="id" value="<?= $campanha['id'] ?>">

            <label>Título:</label>
            <input type="text" name="titulo" value="<?= htmlspecialchars($campanha['titulo']) ?>" required>

            <label>Descrição:</label>
            <textarea name="descricao" required><?= htmlspecialchars($campanha['descricao']) ?></textarea>

            <label>Item do jogo (prêmio):</label>
            <input type="text" name="item" value="<?= htmlspecialchars($campanha['item_premio']) ?>" required>

            <label>Valor por número (R$):</label>
            <input type="number" name="valor" step="0.01" value="<?= $campanha['valor_por_titulo'] ?>" required>

            <label>Data de Início:</label>
            <input type="datetime-local" name="inicio" value="<?= date('Y-m-d\TH:i', strtotime($campanha['data_inicio'])) ?>" required>

            <label>Data de Fim:</label>
            <input type="datetime-local" name="fim" value="<?= date('Y-m-d\TH:i', strtotime($campanha['data_fim'])) ?>" required>

            <label>Total de Títulos:</label>
            <input type="number" name="total" value="<?= $campanha['total_titulos'] ?>" required>

            <input type="submit" value="Atualizar Campanha">
        </form>
    </div>
</section>
</body>
</html>