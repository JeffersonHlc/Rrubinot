<?php
require_once './classes/Usuario.php';

class UsuarioDAO
{
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function salvar(Usuario $usuario) {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $usuario->getNome(),
            $usuario->getEmail(),
            password_hash($usuario->getSenha(), PASSWORD_DEFAULT)
        ]);
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExiste($email) {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function senhaJaUsada($senha) {
        $sql = "SELECT senha FROM usuarios";
        $stmt = $this->conn->query($sql);
        $senhas = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($senhas as $hash) {
            if (password_verify($senha, $hash)) {
                return true;
            }
        }
        return false;
    }

    public function encerrarCampanhasExpiradas() {
        $sql = "UPDATE campanhas SET status = 'encerrada' WHERE data_fim < GETDATE() AND status = 'ativa'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    }
    
}
