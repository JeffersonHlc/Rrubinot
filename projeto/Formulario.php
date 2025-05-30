<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./assets/style.css" />
    <link rel="shortcut icon" href="./assets/icons/cdt.ico" type="image/x-icon" />
    <title>Cadastro</title>
</head>

<body>
    <section>
        <div>
            <?php require_once "./includes/mensagens.php" ?>

            <form action="cadastrar.php" method="post" autocomplete="off">
                <!--label for="nome">Nome: </label-->
                <label class="label-fire" for="email">Nome: </label>
                <input type="text" name="nome" id="nomeId" required />

                <!--label for="email">E-mail: </label>-->
                <label class="label-fire" for="">Email:</label>
                <input type="text" name="email" id="emailId" required />
                <?php exibirErroCampo('email'); ?>

                <!--label for="senha">Senha: </label-->
                <label class="label-fire" for="senha">Senha: </label>
                <input type="password" name="senha" id="senhaId" required />
                <?php exibirErroCampo('senha'); ?>

                <div class="botoes-login-cadastro">
                    <button type="submit">Criar conta</button>
                    <button type="button" onclick="window.location.href='login.php'">Login</button>
                </div>
            </form>
        </div>
    </section>
</body>

</html>