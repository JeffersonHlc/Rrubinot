<?php
session_start();
require_once '../conexao.php';
require_once '../classes/CampanhaDao.php';

$dao = new CampanhaDao($conn);
$vencedores = $dao->buscarVencedores();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Vencedores</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
<section>
    <div>
        <h2>Lista de Vencedores</h2>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID Sorteio</th>
                    <th>Campanha</th>
                    <th>Número Sorteado</th>
                    <th>Nome do Usuário</th>
                    <th>Data do Sorteio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vencedores as $v): ?>
                <tr>
                    <td><?= $v['id'] ?></td>
                    <td><?= htmlspecialchars($v['titulo']) ?></td>
                    <td><?= $v['numero_sorteado'] ?></td>
                    <td><?= htmlspecialchars($v['nome_usuario']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($v['sorteado_em'])) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($vencedores)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Nenhum vencedor registrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="CampanhasList.php">Voltar para Campanhas</a>
    </div>
</section>
</body>
</html>
