<?php
session_start();

if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_perfil'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once '../conexao.php';
require_once '../classes/Campanha.php';
require_once '../classes/CampanhaDao.php';

$dao = new CampanhaDao($conn);
$dao->encerrarCampanhasExpiradas();  // Encerrar campanhas que já passaram da data final
$campanhas = $dao->buscarTodas();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Campanhas</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <h2>Campanhas cadastradas</h2>
        <p><a href="CampanhasCreate.php">Criar Nova Campanha</a></p>

        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Item prêmio</th>
                    <th>Valor por título</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Status</th>
                    <th>Ações</th>
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
                        <td>
                            <a href="CampanhasEdit.php?id=<?= $c['id'] ?>" class="admin-action">Editar</a>
                            <a href="CampanhasEncerrar.php?id=<?= $c['id'] ?>" class="admin-action" onclick="return confirm('Encerrar esta campanha?')">Encerrar</a>
                            <a href="CampanhasSortear.php?id=<?= $c['id'] ?>" class="admin-action">Sortear</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><a href="../usuario/dashboard.php">Voltar ao Dashboard</a></p>
    </div>
</body>
</html>
