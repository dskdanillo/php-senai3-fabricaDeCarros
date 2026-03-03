<?php

final class FabricaController{
     public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/../model/Fabrica.php';
        require_once __DIR__ . '/../model/Carro.php';
    }
public function processa(){
    $fabrica = $_SESSION['fabrica'] ?? null;
    if ($fabrica) {
        $fabrica = unserialize($fabrica);
    } else {
        $fabrica = new Fabrica();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $acao = $_POST['acao'] ?? '';
        $content = '';

        switch ($acao) {

            case 'fabricarcarro':
                $content .= "<h2>Você escolheu a opção fabricar carro</h2>";
                $content .= "<p>Preencha os dados abaixo para definir as características do carro</p>";
                
                $content .= '<form action="index.php" method="POST">'
                    . '<input type="hidden" name="acao" value="salvar_carro">'
                    . '<label><strong>Modelo do carro:</strong></label><br>'
                    . '<input type="text" name="modelo" required><br><br>'
                    . '<label><strong>Cor do carro:</strong></label><br>'
                    . '<input type="text" name="cor" required><br><br>'
                    . '<label><strong>Quantidade de carros:</strong></label><br>'
                    . '<input type="number" name="quantidade" min="1" required><br><br>'
                    . '<button type="submit">Avançar</button>'
                    . '</form>';
                break;

            case 'salvar_carro':
                $modelo = $_POST['modelo'] ?? '';
                $cor = $_POST['cor'] ?? '';
                $quantidade = $_POST['quantidade'] ?? '';

                $content .= "<form action='index.php' method='POST'>                
                <input type='hidden' name='acao' value='finalizar_fabricacao'>                
                <input type='hidden' name='modelo' value='" . htmlspecialchars($modelo, ENT_QUOTES) . "'>              
                 <input type='hidden' name='cor' value='" . htmlspecialchars($cor, ENT_QUOTES) . "'>               
                 <input type='hidden' name='quantidade' value='" . (int)$quantidade . "'>                
                 <button type='submit'>Finalizar Fabricação</button>              </form>";
                break;

            case 'finalizar_fabricacao':
                $modelo = $_POST['modelo'] ?? '';
                $cor = $_POST['cor'] ?? '';
                $quantidade = (int) ($_POST['quantidade'] ?? 0);

                $fabrica->fabricarcarros($quantidade, $modelo, $cor);

                $_SESSION['fabrica'] = serialize($fabrica);

                $content .= "<h2>Carros fabricados com sucesso!</h2>";
                $content .= "<p><strong>Modelo:</strong> {$modelo}</p>";
                $content .= "<p><strong>Cor:</strong> {$cor}</p>";
                $content .= "<p><strong>Quantidade:</strong> {$quantidade}</p>";

                $content .= '<br><a href="../view/index.html">Voltar ao menu</a>';
                break;

            case 'listarcarro':
                $content .= "<h2>Lista de Carros:</h2>";
                $content .= $fabrica->listarcarros();
                $content .= '<br><a href="../view/index.html">Voltar ao menu</a>';
                break;

            case 'limparcarros':
                $fabrica = new Fabrica();
                $_SESSION['fabrica'] = serialize($fabrica);

                $content .= "<h2>Estoque apagado com sucesso</h2>";
                $content .= "<p>Todos os carros fabricados foram removidos.</p>";
                $content .= '<br><a href="../view/index.html">Voltar ao menu</a>';
                break;

            case 'vendercarro':
                $content .= "<h2>Vender Carro</h2>";
                $content .= "            <form action='index.php' method='POST'>               
                <input type='hidden' name='acao' value='confirmar_venda'>                
                <label><strong>Modelo do carro:</strong></label><br>               
                <input type='text' name='modelo' required><br><br>               
                 <label><strong>Cor do carro:</strong></label><br>               
                  <input type='text' name='cor' required><br><br>               
                  <button type='submit'>Vender</button>            
                  </form>        ";
                break;

            case 'confirmar_venda':
                $modelo = $_POST['modelo'] ?? '';
                $cor    = $_POST['cor'] ?? '';

                $vendido = $fabrica->vendercarro($modelo, $cor);

                $_SESSION['fabrica'] = serialize($fabrica);

                if ($vendido) {
                    $content .= "<h2>Carro vendido com sucesso!</h2>";
                    $content .= "<p><strong>Modelo:</strong> {$vendido->getModelo()}</p>";
                    $content .= "<p><strong>Cor:</strong> {$vendido->getCor()}</p>";
                } else {
                    $content .= "<h2>Venda não realizada</h2>";
                    $content .= "<p>Não existe carro com <strong>modelo</strong> '{$modelo}' e <strong>cor</strong> '{$cor}' no estoque.</p>";
                }

                $content .= '<br><a href="../view/index.html">Voltar ao menu</a>';
                break;

            case 'finalizarsessao':
                session_unset();
                session_destroy();

                header("Location: ../view/index.html");
                exit;
        }

        // Monta a página completa com link para o CSS e container similar ao index.html
        $page = "<!DOCTYPE html><html lang=\"pt-br\"><head><meta charset=\"UTF-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><link rel=\"stylesheet\" type=\"text/css\" href=\"../css/style.css\"><title>Fabrica de Carros</title></head><body><div class=\"menu-container\">" . $content . "</div></body></html>";

        echo $page;

    } else {
        header("Location: ../view/index.html");
        exit;
    }
  }
}
?>