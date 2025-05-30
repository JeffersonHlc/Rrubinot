<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../Conexao.php';
require_once '../classes/Campanha.php';
require_once '../classes/CampanhaDao.php';

$dao = new CampanhaDao($conn);

// Buscar campanhas ativas e dentro do período
$campanhasAtivas = $dao->buscarCampanhasAtivas();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Campanhas Ativas</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
<section>
    <div>
        <h2>Campanhas Ativas</h2>
        <?php if (empty($campanhasAtivas)): ?>
            <p>Não há campanhas ativas no momento.</p>
        <?php else: ?>
            <table border="1" cellpadding="5" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Prêmio</th>
                        <th>Valor por título</th>
                        <th>Data início</th>
                        <th>Data fim</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($campanhasAtivas as $campanha): ?>
                    <tr>
                        <td><?= htmlspecialchars($campanha['titulo']) ?></td>
                        <td><?= htmlspecialchars($campanha['item_premio']) ?></td>
                        <td>R$ <?= number_format($campanha['valor_por_titulo'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($campanha['data_inicio'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($campanha['data_fim'])) ?></td>
                        <td><a href="ComprarTitulos.php?id=<?= $campanha['id'] ?>">Comprar títulos</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>
</body>
</html>
