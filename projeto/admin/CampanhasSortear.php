<?php
session_start();
require_once '../conexao.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: CampanhasList.php");
    exit;
}

// Verifica se já foi sorteada
$sqlCheck = "SELECT COUNT(*) FROM vencedores WHERE id_campanha = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->execute([$id]);
if ($stmtCheck->fetchColumn() > 0) {
    $_SESSION['erro'] = "Campanha já foi sorteada.";
    header("Location: CampanhasList.php");
    exit;
}

// Busca um número aleatório pago
$sqlNum = "SELECT t.numero, t.id_usuario FROM titulos t WHERE t.id_campanha = ? AND t.pago_em IS NOT NULL ORDER BY NEWID() OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY";
$stmtNum = $conn->prepare($sqlNum);
$stmtNum->execute([$id]);
$result = $stmtNum->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    $_SESSION['erro'] = "Nenhum título vendido para sorteio.";
    header("Location: CampanhasList.php");
    exit;
}

// Insere o vencedor
$sqlInsert = "INSERT INTO vencedores (id_campanha, numero_sorteado, id_usuario) VALUES (?, ?, ?)";
$stmtInsert = $conn->prepare($sqlInsert);
$stmtInsert->execute([$id, $result['numero'], $result['id_usuario']]);

// Atualiza status da campanha para 'sorteada'
$sqlStatus = "UPDATE campanhas SET status = 'sorteada' WHERE id = ?";
$stmtStatus = $conn->prepare($sqlStatus);
$stmtStatus->execute([$id]);

$_SESSION['sucesso'] = "Sorteio realizado com sucesso! Número vencedor: {$result['numero']}";
header("Location: CampanhasList.php");
exit;
