<?php
require_once 'Aberturas.php';
require_once 'Porta.php';
require_once 'Janela.php';

class Casa {

    private string $descricao;
    private string $cor;
    private array $listaDePortas = [];  
    private array $listaDeJanelas = []; 

    private int $qtdeQuartos;
    private int $qtdeBanheiros;
    private float $tamanhoTotal; // Em metros quadrados (m²)

    // --- GETTERS E SETTERS ORIGINAIS ---
    public function getDescricao(): string {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void {
        $this->descricao = $descricao;
    }

    public function getCor(): string {
        return $this->cor;
    }

    public function setCor(string $cor): void {
        $this->cor = $cor;
    }

    public function getListaDePortas(): array {
        return $this->listaDePortas;
    }

    public function setListaDePortas(array $listaDePortas): void {
        $this->listaDePortas = $listaDePortas;
    }

    public function getListaDeJanelas(): array {
        return $this->listaDeJanelas;
    }

    public function setListaDeJanelas(array $listaDeJanelas): void {
        $this->listaDeJanelas = $listaDeJanelas;
    }

    public function getQtdeQuartos(): int {
        return $this->qtdeQuartos;
    }

    public function setQtdeQuartos(int $qtdeQuartos): void {
        $this->qtdeQuartos = $qtdeQuartos;
    }

    public function getQtdeBanheiros(): int {
        return $this->qtdeBanheiros;
    }

    public function setQtdeBanheiros(int $qtdeBanheiros): void {
        $this->qtdeBanheiros = $qtdeBanheiros;
    }

    public function getTamanhoTotal(): float {
        return $this->tamanhoTotal;
    }

    public function setTamanhoTotal(float $tamanhoTotal): void {
        $this->tamanhoTotal = $tamanhoTotal;
    }

    // --- MÉTODOS DE NEGÓCIO ---

    // Retorna um objeto específico (Porta ou Janela) baseado no tipo e índice do array
    public function retornaAbertura(string $tipo, int $indice): ?Aberturas {
        if ($tipo === 'porta') {
            // Operador de coalescência nula (??) retorna null se o índice não existir
            return $this->listaDePortas[$indice] ?? null;
        } elseif ($tipo === 'janela') {
            return $this->listaDeJanelas[$indice] ?? null;
        }
        return null;
    }

    // Altera o estado (aberto/fechado) de uma abertura específica
    public function moverAbertura(Aberturas $abertura, int $novoEstado): void {
        $abertura->setEstado($novoEstado);
    }

    // --- NOVO MÉTODO (Atividade Complementar 5) ---
    // Percorre as listas e conta quantas estão com estado == 1 (Aberta)
    public function contarAberturasAbertas(): int {
        $contador = 0;
        
        // Conta portas abertas
        foreach ($this->listaDePortas as $porta) {
            if ($porta->getEstado() === 1) {
                $contador++;
            }
        }
        
        // Conta janelas abertas
        foreach ($this->listaDeJanelas as $janela) {
            if ($janela->getEstado() === 1) {
                $contador++;
            }
        }
        
        return $contador;
    }

    // Gera o HTML com o resumo da casa (Atualizado com novos dados)
    public function geraInfoCasa(): string {
        $info = "<h2>Informações da Casa</h2>";
        $info .= "<p><strong>Descrição:</strong> {$this->descricao}</p>";
        $info .= "<p><strong>Cor:</strong> {$this->cor}</p>";
        
        // Exibindo novos dados
        $info .= "<p><strong>Quartos:</strong> {$this->qtdeQuartos}</p>";
        $info .= "<p><strong>Banheiros:</strong> {$this->qtdeBanheiros}</p>";
        $info .= "<p><strong>Tamanho:</strong> {$this->tamanhoTotal} m²</p>";

        // Listagem de Portas
        $info .= "<h3>Portas:</h3>";
        if (empty($this->listaDePortas)) {
            $info .= "<p>Nenhuma porta cadastrada.</p>";
        } else {
            foreach ($this->listaDePortas as $porta) {
                $estado = $porta->getEstadoTexto();
                $info .= "<p>{$porta->getDescricao()} - <strong>{$estado}</strong></p>";
            }
        }

        // Listagem de Janelas
        $info .= "<h3>Janelas:</h3>";
        if (empty($this->listaDeJanelas)) {
            $info .= "<p>Nenhuma janela cadastrada.</p>";
        } else {
            foreach ($this->listaDeJanelas as $janela) {
                $estado = $janela->getEstadoTexto();
                $info .= "<p>{$janela->getDescricao()} - <strong>{$estado}</strong></p>";
            }
        }

        //Exibindo contagem de aberturas 
        $totalAbertas = $this->contarAberturasAbertas();
        $info .= "<hr>";
        $info .= "<p style='color: blue; font-weight: bold;'>Aberturas abertas no momento: {$totalAbertas}</p>";

        return $info;
    }
}
?>