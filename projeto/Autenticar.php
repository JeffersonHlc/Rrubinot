<?php
session_start();
require_once "Conexao.php";
require_once "classes/Usuario.php";
require_once "classes/UsuarioDAO.php";


$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if (empty($email) || empty($senha)) {
    $_SESSION['erro_login'] = "Preencha todos os campos.";
    header("Location: login.php");
    exit;
}

try {
    $dao = new UsuarioDAO($conn);
    $dados = $dao->buscarPorEmail($email);

    if (!$dados || !password_verify($senha, $dados['senha'])) {
        $_SESSION['erro_login'] = "E-mail ou senha inválidos.";
        header("Location: login.php");
        exit;
    }

    // Login válido
    $_SESSION['usuario_id'] = $dados['id'];
    $_SESSION['usuario_nome'] = $dados['nome'];
    $_SESSION['usuario_email'] = $dados['email'];
    $_SESSION['usuario_perfil'] = $dados['perfil'];

    if ($_SESSION['usuario_perfil'] === 'admin') {
        header("Location: admin/CampanhasList.php");
    } else {
        header("Location: usuario/dashboard.php");
    }
    exit;

} catch (PDOException $e) {
    $_SESSION['erro_login'] = "Erro ao processar login. Tente novamente.";
    header("Location: Login.php");
    exit;
}

