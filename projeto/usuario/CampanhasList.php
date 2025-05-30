<?php
session_start();
require_once '../conexao.php';
require_once '../classes/CampanhaDao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$dao = new CampanhaDao($conn);
$campanhas = $dao->buscarTodas();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Campanhas Disponíveis</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <!-- Título da página -->
        <h2>Campanhas Disponíveis</h2>

        <!-- Tabela de campanhas -->
        <table border="1" cellpadding="8" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Item Prêmio</th>
                    <th>Valor por Título</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Status</th>
                    <th>Comprar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($campanhas as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['titulo']) ?></td>
                        <td><?= htmlspecialchars($c['item_premio']) ?></td>
                        <td>R$ <?= number_format($c['valor_por_titulo'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($c['data_inicio'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($c['data_fim'])) ?></td>
                        <td><?= ucfirst($c['status']) ?></td>
                        <td><a href="ComprarTitulo.php?campanha_id=<?= $c['id'] ?>">Comprar</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Botão Voltar -->
        <p><a href="dashboard.php">Voltar ao Dashboard</a></p>
    </div>
</body>
</html>