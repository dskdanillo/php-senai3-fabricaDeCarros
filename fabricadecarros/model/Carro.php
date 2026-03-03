<?php

class Carro
{
    //Atributos privados
    private string $modelo = '';
    private string $cor = '';
    private int $quantidade = 0;

    public function __construct(string $modelo = '', string $cor = '', int $quantidade = 0)
    {
        $this->modelo = $modelo;
        $this->cor = $cor;
        $this->quantidade = $quantidade;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }
    public function setModelo(string $modelo): void
    {
        $this->modelo = $modelo;
    }
    public function getCor(): string
    {
        return $this->cor;
    }
    public function setCor(string $cor): void
    {
        $this->cor = $cor;
    }
    public function getQuantidade(): int
    {
        return $this->quantidade;
    }
    public function setQuantidade(int $quantidade): void
    {
        $this->quantidade = $quantidade;
    }

    public function geraInfoCarro(): string
    {
        $info = "<h2>Informações do carro</h2>";
        $info .= "<p><strong>Modelo:</strong> {$this->modelo}</p>";
        $info .= "<p><strong>Cor:</strong> {$this->cor}</p>";

        return $info;
    }
}
