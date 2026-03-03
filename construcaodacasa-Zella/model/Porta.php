<?php
// Importa o arquivo da classe mãe para que o PHP reconheça a herança
require_once 'Aberturas.php';

// A classe Porta estende (herda de) Aberturas
// Isso é HERANÇA. A Porta ganha automaticamente:
// - atributos $descricao e $estado
// - métodos abrir(), fechar(), getEstadoTexto(), etc.
class Porta extends Aberturas {
    
    // Como a Porta não tem nenhum comportamento especial além do padrão
    // definido em Aberturas, não precisamos escrever nada aqui dentro por enquanto.
    // Ela é uma especialização da classe genérica Aberturas.
}
?>