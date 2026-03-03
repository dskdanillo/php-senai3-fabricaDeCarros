<?php
// Classe abstrata Aberturas
// "Abstract" significa que esta classe serve apenas de modelo.
// Você não pode fazer "new Aberturas()", ela só existe para ser herdada por outras.
abstract class Aberturas {
    
    // ATRIBUTOS
    // "Protected": Diferente de private, atributos protected podem ser acessados
    // pelas classes filhas (Porta e Janela), mas não pelo mundo externo.
    protected string $descricao;
    protected int $estado; // Usamos um inteiro: 0 para fechada, 1 para aberta

    // MÉTODOS GETTERS E SETTERS (Encapsulamento)
    // Permitem ler e alterar os valores dos atributos de forma controlada.

    public function getDescricao(): string {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void {
        $this->descricao = $descricao;
    }

    // Retorna o estado numérico (0 ou 1)
    public function getEstado(): int {
        return $this->estado;
    }

    // Define o estado manualmente
    public function setEstado(int $estado): void {
        $this->estado = $estado;
    }

    // MÉTODOS DE COMPORTAMENTO
    // Simulam as ações reais do objeto no mundo real.

    public function abrir(): void {
        $this->estado = 1; // 1 representa "Aberta"
    }

    public function fechar(): void {
        $this->estado = 0; // 0 representa "Fechada"
    }

    // Método auxiliar para transformar o número em texto legível para o usuário
    public function getEstadoTexto(): string {
        // Operador ternário (Condição ? Verdadeiro : Falso)
        // Se estado for igual a 1, retorna "Aberta", senão retorna "Fechada"
        return $this->estado === 1 ? "Aberta" : "Fechada";
    }
}
?>