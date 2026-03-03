<?php
session_start();

require_once '../model/Fabrica.php';

// Recupera fábrica da sessão
$fabrica = isset($_SESSION['fabrica'])
    ? unserialize($_SESSION['fabrica'])
    : new Fabrica();

$acao = $_POST['acao'] ?? '';

echo "<h2>Fábrica de Carros</h2>";

switch ($acao) {

    // =============================
    // ETAPA 1 - PERGUNTAR QUANTOS
    // =============================
    case 'fabricar':

        echo '
        <form method="POST">
            <input type="hidden" name="acao" value="definir_carros">
            Quantos carros deseja fabricar?
            <input type="number" name="quantidade" required>
            <button type="submit">Continuar</button>
        </form>';
    break;

    // =============================
    // ETAPA 2 - CRIAR FORM DINÂMICO
    // =============================
    case 'definir_carros':

        $qtd = (int)$_POST['quantidade'];

        echo '<form method="POST">';
        echo '<input type="hidden" name="acao" value="salvar_carros">';
        echo "<input type='hidden' name='qtd' value='$qtd'>";

        for ($i=0;$i<$qtd;$i++) {

            echo "<h3>Carro ".($i+1)."</h3>";
            echo "Modelo: <input name='modelo_$i' required><br>";
            echo "Cor: <input name='cor_$i' required><br><br>";
        }

        echo '<button>Fabricar</button></form>';
    break;

    // =============================
    // ETAPA 3 - FABRICAR
    // =============================
    case 'salvar_carros':

        $qtd = (int)$_POST['qtd'];
        $dados = [];

        for ($i=0;$i<$qtd;$i++) {
            $dados[] = [
                'modelo'=>$_POST["modelo_$i"],
                'cor'=>$_POST["cor_$i"]
            ];
        }

        $fabrica->fabricarCarro($dados);

        $_SESSION['fabrica'] = serialize($fabrica);

        echo "<p>Carros fabricados com sucesso!</p>";
    break;

    // =============================
    // VENDER
    // =============================
    case 'vender':

        echo '
        <form method="POST">
            <input type="hidden" name="acao" value="remover">
            Modelo: <input name="modelo" required><br>
            Cor: <input name="cor" required><br>
            <button>Vender</button>
        </form>';
    break;

    case 'remover':

        $ok = $fabrica->venderCarro($_POST['modelo'], $_POST['cor']);

        echo $ok
            ? "<p>Carro vendido!</p>"
            : "<p>Carro não encontrado.</p>";

        $_SESSION['fabrica'] = serialize($fabrica);
    break;

    // =============================
    // VER INFORMAÇÕES
    // =============================
    case 'ver':
        echo $fabrica->listarCarros();
    break;

    // =============================
    // FINALIZAR
    // =============================
    case 'limpar':
        session_destroy();
        echo "<p>Sessão finalizada.</p>";
    break;
}

echo '<br><a href="../view/index.html">Voltar</a>';
?>