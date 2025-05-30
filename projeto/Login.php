<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="./icons/cdt.ico" type="image/x-icon" />
    <link rel="stylesheet" href="./assets/style.css" />
    <title>Login</title>
</head>

<body>
    <section>
        <div>
            <?php include './includes/mensagens.php'; ?>

            <form action="autenticar.php" method="post" autocomplete="off">
                <label class="label-fire" for="senha">E-mail: </label>
                <input type="text" name="email" id="emailId" required />

                <label class="label-fire" for="senha">Senha: </label>
                <input type="password" name="senha" id="senhaId" required />

                <div class="botoes-login-cadastro">
                    <button type="submit">Login</button>
                    <button type="button" onclick="window.location.href='cadastrar.php'">Voltar</button>

                </div>
            </form>
    </section>
</body>

</html>