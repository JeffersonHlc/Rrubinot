<?php
$serverName = "172.16.3.58";
$database = "cadastro";
$username = "sa";
$password = "UNIDEV01.,";

try {
    // Conectando via PDO com driver sqlsrv
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo "Conexão com SQL Server estabelecida com sucesso!";
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
