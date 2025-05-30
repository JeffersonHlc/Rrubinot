<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../conexao.php';
require_once '../classes/Campanha.php';
require_once '../classes/CampanhaDao.php';

$idCampanha = $_GET['id'] ?? null;
if (!$idCampanha) {
    $_SESSION['erro'] = "Campanha inválida.";
    header("Location: CampanhasAtivas.php");
    exit;
}

$dao = new CampanhaDao($conn);
$campanha = $dao->buscarPorId($idCampanha);

if (!$campanha || $campanha['status'] !== 'ativa') {
    $_SESSION['erro'] = "Campanha não disponível para compra.";
    header("Location: CampanhasAtivas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Comprar Títulos - <?= htmlspecialchars($campanha['titulo']) ?></title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
<section>
    <div>
        <h2>Comprar Títulos da Campanha</h2>
        <h3><?= htmlspecialchars($campanha['titulo']) ?></h3>
        <p>Prêmio: <?= htmlspecialchars($campanha['item_premio']) ?></p>
        <p>Valor por título: R$ <?= number_format($campanha['valor_por_titulo'], 2, ',', '.') ?></p>

        <form action="ProcessarCompra.php" method="post">
            <input type="hidden" name="id_campanha" value="<?= $campanha['id'] ?>" />
            <label for="quantidade">Quantidade de títulos:</label>
            <input type="number" id="quantidade" name="quantidade" min="1" max="1000" required />
            <input type="submit" value="Comprar" />
        </form>

        <p><a href="CampanhasAtivas.php">Voltar para Campanhas Ativas</a></p>
    </div>
</section>
</body>
</html>
