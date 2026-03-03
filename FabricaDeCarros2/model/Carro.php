<?php
// Classe Carro
// Representa um único carro fabricado

class Carro {

    // ATRIBUTOS OBRIGATÓRIOS
    private string $modelo;
    private string $cor;

    // GETTERS E SETTERS (Encapsulamento)

    public function getModelo(): string {
        return $this->modelo;
    }

    public function setModelo(string $modelo): void {
        $this->modelo = $modelo;
    }

    public function getCor(): string {
        return $this->cor;
    }

    public function setCor(string $cor): void {
        $this->cor = $cor;
    }
}
?>