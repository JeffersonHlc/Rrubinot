gerar_hash.php<?php
$senha = '123Admin@'; // substitua pela senha que quiser
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo $hash;
