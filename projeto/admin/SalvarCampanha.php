<?php
session_start();
require_once '../conexao.php';
require_once '../classes/Campanha.php';
require_once '../classes/CampanhaDao.php';

// Validação simples dos dados
$titulo = trim($_POST['titulo'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$itemPremio = trim($_POST['item_premio'] ?? '');
$valorPorTitulo = floatval($_POST['valor_por_titulo'] ?? 0);
$dataInicioRaw = $_POST['data_inicio'] ?? '';
$dataFimRaw = $_POST['data_fim'] ?? '';
$totalTitulos = intval($_POST['total_titulos'] ?? 10000);

if (empty($titulo) || empty($descricao) || empty($itemPremio) || $valorPorTitulo <= 0 || empty($dataInicioRaw) || empty($dataFimRaw) || $totalTitulos <= 0) {
    $_SESSION['erro'] = "Preencha todos os campos corretamente.";
    header("Location: CampanhasCreate.php");
    exit;
}

// Converte o formato das datas
$dataInicioObj = DateTime::createFromFormat('Y-m-d\TH:i', $dataInicioRaw);
$dataFimObj = DateTime::createFromFormat('Y-m-d\TH:i', $dataFimRaw);

if (!$dataInicioObj || !$dataFimObj) {
    $_SESSION['erro'] = "Data inválida.";
    header("Location: CampanhasCreate.php");
    exit;
}

$dataInicio = $dataInicioObj->format('Y-m-d H:i:s');
$dataFim = $dataFimObj->format('Y-m-d H:i:s');

// Criar objeto Campanha com datas formatadas
$campanha = new Campanha($titulo, $descricao, $itemPremio, $valorPorTitulo, $dataInicio, $dataFim, $totalTitulos);

$dao = new CampanhaDao($conn);

try {
    $dao->salvar($campanha);
    $_SESSION['sucesso'] = "Campanha criada com sucesso!";
    header("Location: CampanhasList.php");
    exit;
} catch (Exception $e) {
    $_SESSION['erro'] = "Erro ao criar campanha: " . $e->getMessage();
    header("Location: CampanhasCreate.php");
    exit;
}