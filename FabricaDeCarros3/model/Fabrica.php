 <?php
require_once 'Carro.php';

        // A fábrica GUARDA vários carros
        class Fabrica {

            private array $carros = [];

            // FABRICAR (adiciona carros)
            public function fabricarCarro(array $dados){

                foreach($dados as $d){

                    $carro = new Carro();
                    $carro->setModelo($d['modelo']);
                    $carro->setCor($d['cor']);

                    $this->carros[] = $carro;
                }
            }
//--------------------------------------------------------------------VENDER (remove carro)
            public function venderCarro($modelo,$cor){

                foreach($this->carros as $i=>$carro){

                    if(
                        strtolower($carro->getModelo()) == strtolower($modelo)
                        &&
                        strtolower($carro->getCor()) == strtolower($cor)
                    ){
                        unset($this->carros[$i]);
                        return true;
                    }
                }
                return false;
            }

        public function getCarros(){
            return $this->carros;
        }

//---------------------------------------------------------------------LISTAR
        public function listarCarros(){

            if(empty($this->carros))
                return "<p>Nenhum carro fabricado.</p>";

            $html="<h3>Carros Fabricados</h3>";

            foreach($this->carros as $c){
                $html.="<p>Modelo: ".$c->getModelo().
                        " | Cor: ".$c->getCor()."</p>";
            }

            return $html;
        }
    }
    ?>