<?php
// Importa o arquivo da classe mãe
require_once 'Aberturas.php';

// A classe Janela estende (herda de) Aberturas
// Graças à HERANÇA, evitamos repetir todo o código de abrir/fechar/get/set
// que já escrevemos na classe Aberturas.
class Janela extends Aberturas {
    
    // Assim como Porta, Janela utiliza toda a lógica da classe mãe.
    // Se no futuro quiséssemos algo exclusivo de janela (ex: colocar cortina),
    // escreveríamos o método aqui.
}
?>