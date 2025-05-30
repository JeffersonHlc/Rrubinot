<?php

class Campanha {
    private $titulo;
    private $descricao;
    private $itemPremio;
    private $valorPorTitulo;
    private $dataInicio;
    private $dataFim;
    private $totalTitulos;

    public function __construct($titulo, $descricao, $itemPremio, $valorPorTitulo, $dataInicio, $dataFim, $totalTitulos = 10000) {
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->itemPremio = $itemPremio;
        $this->valorPorTitulo = $valorPorTitulo;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
        $this->totalTitulos = $totalTitulos;
    }

    public function getTitulo() { return $this->titulo; }
    public function getDescricao() { return $this->descricao; }
    public function getItemPremio() { return $this->itemPremio; }
    public function getValorPorTitulo() { return $this->valorPorTitulo; }
    public function getDataInicio() { return $this->dataInicio; }
    public function getDataFim() { return $this->dataFim; }
    public function getTotalTitulos() { return $this->totalTitulos; }
}
