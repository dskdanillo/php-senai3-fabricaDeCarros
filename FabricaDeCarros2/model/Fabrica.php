<?php
require_once 'Carro.php';

// Classe Fabrica
class Fabrica {

    // Array que guarda os carros fabricados
    private array $carros = [];

    // ===============================
    // FABRICAR CARROS
    // ===============================
    public function fabricarCarro(array $dadosCarros): void {

        // percorre todos os carros enviados pelo formulário
        foreach ($dadosCarros as $dados) {

            $carro = new Carro();
            $carro->setModelo($dados['modelo']);
            $carro->setCor($dados['cor']);

            // adiciona no estoque da fábrica
            $this->carros[] = $carro;
        }
    }

    // ===============================
    // VENDER CARRO
    // ===============================
    public function venderCarro(string $modelo, string $cor): bool {

        foreach ($this->carros as $indice => $carro) {

            if (
                strtolower($carro->getModelo()) == strtolower($modelo) &&
                strtolower($carro->getCor()) == strtolower($cor)
            ) {
                // remove do array
                unset($this->carros[$indice]);
                return true;
            }
        }

        return false;
    }

    // ===============================
    // LISTAR CARROS
    // ===============================
    public function listarCarros(): string {

        if (empty($this->carros)) {
            return "<p>Nenhum carro na fábrica.</p>";
        }

        $info = "<h3>Carros Fabricados:</h3>";

        foreach ($this->carros as $carro) {
            $info .= "<p>
                        Modelo: <strong>{$carro->getModelo()}</strong> |
                        Cor: <strong>{$carro->getCor()}</strong>
                      </p>";
        }

        return $info;
    }
}
?>