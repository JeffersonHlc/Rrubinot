<?php
session_start();
require_once "conexao.php";
require_once "classes/Usuario.php";
require_once "classes/UsuarioDAO.php";

$nome  = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if (empty($nome) || empty($email) || empty($senha)) {
    $_SESSION['erro_email'] = "Preencha todos os campos.";
    header("Location: formulario.php");
    exit;
}

$usuario = new Usuario($nome, $email, $senha);
$dao = new UsuarioDAO($conn);

// Verifica e-mail já cadastrado
if ($dao->emailExiste($email)) {
    $_SESSION['erro_email'] = "Este e-mail já está cadastrado.";
    header("Location: formulario.php");
    exit;
}

// Verifica se a senha já foi usada
if ($dao->senhaJaUsada($senha)) {
    $_SESSION['erro_senha'] = "Esta senha já está sendo usada.";
    header("Location: formulario.php");
    exit;
}

// Salva o usuário
$dao->salvar($usuario);
$_SESSION['sucesso'] = "Usuário cadastrado com sucesso! Faça login para continuar.";
header("Location: login.php");
exit;
