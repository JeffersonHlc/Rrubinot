<?php
session_start();
require_once '../conexao.php';
require_once '../classes/Campanha.php';
require_once '../classes/CampanhaDao.php';

$id = intval($_POST['id'] ?? 0);
$titulo = trim($_POST['titulo'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$item = trim($_POST['item'] ?? '');
$valor = floatval($_POST['valor'] ?? 0);
$inicio = $_POST['inicio'] ?? '';
$fim = $_POST['fim'] ?? '';
$total = intval($_POST['total'] ?? 10000);

$dao = new CampanhaDao($conn);
$campanhaAtual = $dao->buscarPorId($id);

if (!$campanhaAtual) {
    $_SESSION['erro'] = "Campanha não encontrada.";
    header("Location: CampanhasList.php");
    exit;
}

// Atualiza dados da campanha no banco
$sql = "UPDATE campanhas SET titulo = ?, descricao = ?, item_premio = ?, valor_por_titulo = ?, data_inicio = ?, data_fim = ?, total_titulos = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$titulo, $descricao, $item, $valor, $inicio, $fim, $total, $id]);

$_SESSION['sucesso'] = "Campanha atualizada com sucesso.";
header("Location: CampanhasList.php");
exit;
