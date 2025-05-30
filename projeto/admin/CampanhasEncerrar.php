<?php
session_start();
require_once '../conexao.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: CampanhasList.php");
    exit;
}

$sql = "UPDATE campanhas SET status = 'encerrada' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

$_SESSION['sucesso'] = "Campanha encerrada com sucesso.";
header("Location: CampanhasList.php");
exit;
