<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Login.php");
    exit;
}

// Pega nome e perfil da sessão
$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';
$perfil = $_SESSION['usuario_perfil'] ?? 'usuario'; // padrão usuário comum
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../assets/style.css" />
    <title>Dashboard</title>
</head>

<body>
    <section>
        <div>
            <h1>Bem-vindo, <?= htmlspecialchars($nomeUsuario) ?>!</h1>
            <p>Esta é sua área restrita.</p>

            <nav>
                <ul>
                    <li><a href="CampanhasList.php">Listar Campanhas</a></li>
                    <?php if ($perfil === 'admin'): ?>
                        <li><a href="../admin/CampanhasList.php">Listar Campanhas</a></li>
                    <?php endif; ?>
                    <li><a href="../logout.php">Sair</a></li>
                </ul>
            </nav>

        </div>
    </section>
</body>

</html>