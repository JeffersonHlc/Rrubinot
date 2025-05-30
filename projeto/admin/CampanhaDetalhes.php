<?php
session_start();
require_once '../conexao.php';
require_once '../classes/CampanhaDao.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['erro'] = "Campanha inválida.";
    header("Location: CampanhasList.php");
    exit;
}

$dao = new CampanhaDao($conn);
$campanha = $dao->buscarPorIdComTitulos($id);

if (!$campanha) {
    $_SESSION['erro'] = "Campanha não encontrada.";
    header("Location: CampanhasList.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Detalhes da Campanha</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
<section>
    <div>
        <h2>Detalhes da Campanha: <?= htmlspecialchars($campanha['titulo']) ?></h2>
        <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($campanha['descricao'])) ?></p>
        <p><strong>Item prêmio:</strong> <?= htmlspecialchars($campanha['item_premio']) ?></p>
        <p><strong>Valor por número:</strong> R$ <?= number_format($campanha['valor_por_titulo'], 2, ',', '.') ?></p>
        <p><strong>Período:</strong> <?= date('d/m/Y H:i', strtotime($campanha['data_inicio'])) ?> até <?= date('d/m/Y H:i', strtotime($campanha['data_fim'])) ?></p>
        <p><strong>Status:</strong> <?= ucfirst($campanha['status']) ?></p>

        <h3>Títulos vendidos (<?= count($campanha['titulos_vendidos']) ?>):</h3>
        <?php if (empty($campanha['titulos_vendidos'])): ?>
            <p>Nenhum título vendido ainda.</p>
        <?php else: ?>
            <table border="1" cellpadding="5" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Comprador</th>
                        <th>Data da compra</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($campanha['titulos_vendidos'] as $titulo): ?>
                        <tr>
                            <td><?= $titulo['numero'] ?></td>
                            <td><?= htmlspecialchars($titulo['usuario_nome']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($titulo['pago_em'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <a href="CampanhasList.php">Voltar para Campanhas</a>
    </div>
</section>
</body>
</html>
