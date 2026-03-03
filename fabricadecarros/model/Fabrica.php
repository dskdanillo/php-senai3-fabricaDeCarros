<?php
require_once 'Carro.php';
class Fabrica
{

    private array $carros = [];


    public function fabricarcarros(int $quantidade, string $modelo, string $cor): void
    {
        for ($i = 0; $i < $quantidade; $i++) {
            $this->carros[] = new Carro($modelo, $cor);
        }
    }
    public function vendercarro(string $modelo, string $cor): ?Carro
    {
        $modelo = mb_strtolower(trim($modelo));
        $cor    = mb_strtolower(trim($cor));

        foreach ($this->carros as $index => $carro) {
            $modeloCarro = mb_strtolower(trim($carro->getModelo()));
            $corCarro    = mb_strtolower(trim($carro->getCor()));

            if ($modeloCarro === $modelo && $corCarro === $cor) {
                $vendido = $carro;
                unset($this->carros[$index]);
                $this->carros = array_values($this->carros);
                return $vendido;
            }
        }
        return null;
    }

    public function listarcarros(): string
    {
        if (count($this->carros) === 0) {
            return "<p>Nenhum carro no estoque da fábrica.</p>";
        }
        $html = "<h2>Estoque da fábrica (" . count($this->carros) . ")<h2/>";

        foreach ($this->carros as $index => $carro) {
            $num = $index + 1;
            $html .= "<div style='border:1px solid #ccc; padding:10px; margin:10px 0;'>";
            $html .= "<h3>Carro #{$num}</h3>";

            $html .= "<p><strong>Modelo:</strong>" . $carro->getModelo() . "</p>";
            $html .= "<p><strong>Cor:</strong> " . $carro->getCor() . "</p>";
            $html .= "</div>";
        }
        return $html;
    }
}
