<?php
require_once 'Campanha.php';

class CampanhaDAO
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function salvar(Campanha $campanha)
    {
        $sql = "INSERT INTO campanhas (titulo, descricao, item_premio, valor_por_titulo, data_inicio, data_fim, total_titulos, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'ativa')";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $campanha->getTitulo(),
            $campanha->getDescricao(),
            $campanha->getItemPremio(),
            $campanha->getValorPorTitulo(),
            $campanha->getDataInicio(),
            $campanha->getDataFim(),
            $campanha->getTotalTitulos()
        ]);

        $idCampanha = $this->conn->lastInsertId();
        $this->gerarTitulos($idCampanha, $campanha->getTotalTitulos());
        return $idCampanha;
    }

    private function gerarTitulos($idCampanha, $quantidade)
    {
        $sql = "INSERT INTO titulos (id_campanha, numero) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);

        for ($i = 0; $i < $quantidade; $i++) {
            $stmt->execute([$idCampanha, $i]);
        }
    }

    public function buscarTodas()
    {
        $sql = "SELECT * FROM campanhas ORDER BY data_inicio DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM campanhas WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarVencedores()
    {
        $sql = "SELECT v.id, c.titulo, v.numero_sorteado, u.nome as nome_usuario, v.sorteado_em
                FROM vencedores v
                JOIN campanhas c ON v.id_campanha = c.id
                JOIN usuarios u ON v.id_usuario = u.id
                ORDER BY v.sorteado_em DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorIdComTitulos($id)
    {
        // Busca campanha
        $sqlCampanha = "SELECT * FROM campanhas WHERE id = ?";
        $stmtCampanha = $this->conn->prepare($sqlCampanha);
        $stmtCampanha->execute([$id]);
        $campanha = $stmtCampanha->fetch(PDO::FETCH_ASSOC);

        if (!$campanha) {
            return null;
        }

        // Busca títulos vendidos (com usuário)
        $sqlTitulos = "SELECT t.numero, u.nome as usuario_nome, t.pago_em
                      FROM titulos t
                      LEFT JOIN usuarios u ON t.id_usuario = u.id
                      WHERE t.id_campanha = ? AND t.pago_em IS NOT NULL
                      ORDER BY t.numero ASC";
        $stmtTitulos = $this->conn->prepare($sqlTitulos);
        $stmtTitulos->execute([$id]);
        $titulos = $stmtTitulos->fetchAll(PDO::FETCH_ASSOC);

        $campanha['titulos_vendidos'] = $titulos;

        return $campanha;
    }

    public function encerrarCampanhasExpiradas()
    {
        $sql = "UPDATE campanhas SET status = 'encerrada' WHERE data_fim < GETDATE() AND status = 'ativa'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    }

    public function buscarCampanhasAtivas()
{
    $sql = "SELECT * FROM campanhas 
            WHERE status = 'ativa' 
            AND data_inicio <= GETDATE() 
            AND data_fim >= GETDATE()
            ORDER BY data_inicio DESC";

    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
