<?php
session_start();

require_once '../model/Fabrica.php';

$fabrica = isset($_SESSION['fabrica'])
 ? unserialize($_SESSION['fabrica'])
 : new Fabrica();

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

$qtd=$_POST['qtd'];
$dados=[];

for($i=0;$i<$qtd;$i++){
$dados[]=[
'modelo'=>$_POST["modelo_$i"],
'cor'=>$_POST["cor_$i"]
];
}

$fabrica->fabricarCarro($dados);
$_SESSION['fabrica']=serialize($fabrica);

echo "<div class='box'><h2>Carros fabricados!</h2>
<a href='../view/index.html'>Menu</a></div>";
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

if($fabrica->venderCarro($_POST['modelo'],$_POST['cor']))
echo "<div class='box'>Carro vendido!</div>";
else
echo "<div class='box'>Carro não encontrado!</div>";

$_SESSION['fabrica']=serialize($fabrica);

echo "<a href='../view/index.html'>Menu</a>";
break;

case 'ver':

echo "<div class='box'>";
echo $fabrica->listarCarros();
echo "<br><a href='../view/index.html'>Menu</a></div>";
break;

case 'limpar':
session_destroy();
echo "<div class='box'>Sessão finalizada</div>";
break;
}
?>