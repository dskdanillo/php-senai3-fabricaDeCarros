<?php

class Carro {

    private string $modelo;
    private string $cor;

    public function setModelo(string $modelo){
        $this->modelo = $modelo;
    }

    public function getModelo(): string{
        return $this->modelo;
    }

    public function setCor(string $cor){
        $this->cor = $cor;
    }

    public function getCor(): string{
        return $this->cor;
    }
}
?>