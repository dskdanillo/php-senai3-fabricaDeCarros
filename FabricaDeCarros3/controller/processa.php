<?php
$pdo = new PDO("mysql:host=localhost;dbname=fabrica", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$acao = $_POST['acao'] ?? '';

echo "<link rel='stylesheet' href='../view/css/estilo.css'>";
echo "<script src='../view/js/validacao.js'></script>";

switch($acao){

case 'fabricar':

echo '
<div class="box">
<h2>Quantos carros deseja fabricar?</h2>

<form method="POST">
<input type="hidden" name="acao" value="dados">
<input type="number" name="qtd" min="1" required>
<button>Avançar</button>
</form>
</div>';
break;

case 'dados':

$qtd=(int)$_POST['qtd'];

echo "<div class='box'><form method='POST'>";
echo "<input type='hidden' name='acao' value='salvar'>";
echo "<input type='hidden' name='qtd' value='$qtd'>";

for($i=0;$i<$qtd;$i++){
echo "
<h3>Carro ".($i+1)."</h3>
Modelo:<input name='modelo_$i' class='modelo' required>
Cor:<input name='cor_$i' class='cor' required><br><br>";
}

echo "<button>Fabricar</button></form></div>";
break;

case 'salvar':

    case 'salvar':

        require_once '../conexao.php';
        
        $qtd = $_POST['qtd'];
        
        for($i=0;$i<$qtd;$i++){
            $modelo = $_POST["modelo_$i"];
            $cor = $_POST["cor_$i"];
        
            $sql = "INSERT INTO carros (modelo, cor) VALUES (?, ?)";//INSERT introduz os valores no banco 
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$modelo, $cor]);
        }
        
        echo "<div class='box'>Carros salvos no banco!</div>";
        echo "<br><a href='../view/index.html'><button>Voltar para tela inicial</button></a>";
    
        break;

case 'vender':

echo '
<div class="box">
<form method="POST">
<input type="hidden" name="acao" value="remover">
Modelo:<input name="modelo" class="modelo" required>
Cor:<input name="cor" class="cor" required>
<button>Vender</button>
</form>
</div>';
break;

case 'remover':

    require_once '../conexao.php';// Puxa a conexao com o banco
    
    $modelo = $_POST['modelo'];
    $cor = $_POST['cor'];
    
    $sql = "DELETE FROM carros WHERE modelo = ? AND cor = ?";// DELETE FRON  comando que remove o dado do banco
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$modelo, $cor]);
    
    if($stmt->rowCount() > 0){
        echo "<div class='box'>Carro vendido!</div>";
    } else {
        echo "<div class='box'>Carro não encontrado!</div>";
    }
    
    echo "<a href='../view/index.html'>Menu</a>";
    break;

    case 'ver':

        require_once '../conexao.php';
        
        $sql = "SELECT * FROM carros";
        $stmt = $pdo->query($sql);
        
        echo "<div class='box'>";
        echo "<h2>Lista de Carros</h2>";
        
        foreach($stmt as $row){
            echo "ID: {$row['id']} - Modelo: {$row['modelo']} - Cor: {$row['cor']}<br>";
        }
        
        echo "<br><a href='../view/index.html'>Menu</a></div>";
        break;



        case 'limpar':

            require_once '../conexao.php';
            
            $pdo->exec("DELETE FROM carros");
            
            echo "<div class='box'>Banco limpo!</div>";
            break;
}
?>