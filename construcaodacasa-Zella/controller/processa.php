<?php
session_start();

    echo '
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Construção da Casa</title>
        <link rel="stylesheet" href="../view/css/processa.css">
    </head>
    <body>
    ';


require_once '../model/Casa.php';
require_once '../model/Porta.php';
require_once '../model/Janela.php';

$acao = $_POST['acao'] ?? '';

switch ($acao) {


    case 'construir':
        echo "<h2>Construção da Casa</h2>";
        echo "<p>Preencha os dados da casa:</p>";
        echo '
        <form action="processa.php" method="POST">
            <!-- Define a próxima ação do fluxo -->
            <input type="hidden" name="acao" value="salvar_casa">
            
            <label><strong>Descrição:</strong></label><br>
            <input type="text" name="descricao" required placeholder="Ex: Casa de Campo"><br>

            <label><strong>Cor:</strong></label><br>
            <input type="text" name="cor" required placeholder="Ex: Branca"><br>

            <!-- NOVOS CAMPOS (Atividade Complementar) -->
            <label><strong>Qtd. Quartos:</strong></label><br>
            <input type="number" name="qtde_quartos" min="0" required><br>

            <label><strong>Qtd. Banheiros:</strong></label><br>
            <input type="number" name="qtde_banheiros" min="0" required><br>

            <label><strong>Tamanho (m²):</strong></label><br>
            <input type="number" name="tamanho_total" min="0" step="0.01" required><br>
            <!-- FIM NOVOS CAMPOS -->

            <label><strong>Qtd. Portas:</strong></label><br>
            <input type="number" name="qtde_portas" min="0" required><br>

            <label><strong>Qtd. Janelas:</strong></label><br>
            <input type="number" name="qtde_janelas" min="0" required><br>

            <button type="submit">Avançar</button>
        </form>';
        break;

    case 'salvar_casa':

        $descricao = $_POST['descricao'] ?? '';
        $cor = $_POST['cor'] ?? '';
        
        // Recupera os novos campos complementares
        $qtdeQuartos = (int)($_POST['qtde_quartos'] ?? 0);
        $qtdeBanheiros = (int)($_POST['qtde_banheiros'] ?? 0);
        $tamanhoTotal = (float)($_POST['tamanho_total'] ?? 0);

        $qtdePortas = (int)($_POST['qtde_portas'] ?? 0);
        $qtdeJanelas = (int)($_POST['qtde_janelas'] ?? 0);

        echo "<h2>Definir aberturas</h2>";
        echo '<form action="processa.php" method="POST">';
        echo '<input type="hidden" name="acao" value="finalizar_casa">';
        
        // IMPORTANTE: Inputs do tipo 'hidden' (ocultos)
        // Como o PHP "esquece" os dados a cada página carregada, precisamos
        // reenviar esses dados de formulário em formulário até a hora de criar o objeto.
        echo "<input type='hidden' name='descricao' value='$descricao'>";
        echo "<input type='hidden' name='cor' value='$cor'>";
        echo "<input type='hidden' name='qtde_quartos' value='$qtdeQuartos'>";
        echo "<input type='hidden' name='qtde_banheiros' value='$qtdeBanheiros'>";
        echo "<input type='hidden' name='tamanho_total' value='$tamanhoTotal'>";
        echo "<input type='hidden' name='qtde_portas' value='$qtdePortas'>";
        echo "<input type='hidden' name='qtde_janelas' value='$qtdeJanelas'>";

        // Gera campos dinamicamente baseado na quantidade de portas
        if ($qtdePortas > 0) {
            echo "<h3>Portas</h3>";
            for ($i = 0; $i < $qtdePortas; $i++) {
                echo "<p><strong>Porta " . ($i + 1) . "</strong></p>";
                echo "<label>Descrição:</label><input type='text' name='descricao_porta_$i' required><br>";
                echo "<label>Estado:</label><select name='estado_porta_$i'>
                        <option value='0'>Fechada</option>
                        <option value='1'>Aberta</option>
                      </select><br>";
            }
        }

        // Gera campos dinamicamente baseado na quantidade de janelas
        if ($qtdeJanelas > 0) {
            echo "<h3>Janelas</h3>";
            for ($i = 0; $i < $qtdeJanelas; $i++) {
                echo "<p><strong>Janela " . ($i + 1) . "</strong></p>";
                echo "<label>Descrição:</label><input type='text' name='descricao_janela_$i' required><br>";
                echo "<label>Estado:</label><select name='estado_janela_$i'>
                        <option value='0'>Fechada</option>
                        <option value='1'>Aberta</option>
                      </select><br>";
            }
        }

        echo '<br><button type="submit">Finalizar Construção</button>';
        echo '</form>';
        break;

    // ETAPA 3: Finalização, Criação do Objeto e Persistência
    case 'finalizar_casa':
        // 1. Coleta todos os dados vindos via POST (ocultos e novos)
        $descricao = $_POST['descricao'] ?? '';
        $cor = $_POST['cor'] ?? '';
        $qtdeQuartos = (int)($_POST['qtde_quartos'] ?? 0);
        $qtdeBanheiros = (int)($_POST['qtde_banheiros'] ?? 0);
        $tamanhoTotal = (float)($_POST['tamanho_total'] ?? 0);
        $qtdePortas = (int)($_POST['qtde_portas'] ?? 0);
        $qtdeJanelas = (int)($_POST['qtde_janelas'] ?? 0);

        // 2. Cria a instância (objeto) da classe Casa
        $casa = new Casa();
        $casa->setDescricao($descricao);
        $casa->setCor($cor);
        
        // Seta os novos atributos complementares
        $casa->setQtdeQuartos($qtdeQuartos);
        $casa->setQtdeBanheiros($qtdeBanheiros);
        $casa->setTamanhoTotal($tamanhoTotal);

        // 3. Cria e adiciona as Portas ao objeto Casa
        $listaPortas = [];
        for ($i = 0; $i < $qtdePortas; $i++) {
            $porta = new Porta();
            $porta->setDescricao($_POST["descricao_porta_$i"]);
            $porta->setEstado((int)$_POST["estado_porta_$i"]);
            $listaPortas[] = $porta;
        }
        $casa->setListaDePortas($listaPortas);

        // 4. Cria e adiciona as Janelas ao objeto Casa
        $listaJanelas = [];
        for ($i = 0; $i < $qtdeJanelas; $i++) {
            $janela = new Janela();
            $janela->setDescricao($_POST["descricao_janela_$i"]);
            $janela->setEstado((int)$_POST["estado_janela_$i"]);
            $listaJanelas[] = $janela;
        }
        $casa->setListaDeJanelas($listaJanelas);

        // --- EXPLICAÇÃO SOBRE SERIALIZAÇÃO ---
        // A sessão ($_SESSION) é ótima para guardar textos e números, mas não sabe 
        // lidar nativamente com a estrutura complexa de um objeto (com métodos e propriedades).
        // 
        // O comando 'serialize($objeto)' converte todo o objeto e seus dados em uma 
        // string (um texto codificado). Assim, podemos guardá-lo na sessão.
        // Quando precisarmos usar o objeto de novo, usamos 'unserialize()'.
        $_SESSION['casa'] = serialize($casa);

        echo "<h2>Casa construída com sucesso!</h2>";
        // Chama o método para exibir o resumo (incluindo novos dados e contagem)
        echo $casa->geraInfoCasa(); 
        echo '<br><br><a href="../view/index.html">Voltar ao menu</a>';
        break;

    // ETAPA 4: Movimentação - Seleção do Tipo
    case 'movimentar':
        // Verifica se existe uma casa salva na sessão antes de tentar mover algo
        if (!isset($_SESSION['casa'])) {
            echo "<h2>Nenhuma casa foi construída ainda!</h2>";
            echo '<a href="../view/index.html">Voltar ao menu</a>';
            exit;
        }
        echo "<h2>Movimentar Aberturas</h2>";
        echo "<p>Informe o tipo:</p>";
        echo '
        <form action="processa.php" method="POST">
            <input type="hidden" name="acao" value="selecionar_tipo_abertura">
            <button type="submit" name="tipo_abertura" value="porta">Mover Porta</button>
            <button type="submit" name="tipo_abertura" value="janela">Mover Janela</button>
        </form>';
        echo '<br><a href="../view/index.html">Voltar ao menu</a>';
        break;

    // ETAPA 4.X: Redirecionamento intermediário
    case 'selecionar_tipo_abertura':
        $tipo = $_POST['tipo_abertura'] ?? '';
        // Cria um formulário automático para passar os dados para a próxima etapa
        echo '<form action="processa.php" method="POST">
                <input type="hidden" name="acao" value="selecionar_abertura">
                <input type="hidden" name="tipo" value="'.$tipo.'">
                <button type="submit">Continuar</button>
              </form>';
        // Script JS para enviar automaticamente sem clique
        echo '<script>document.forms[0].submit();</script>';
        break;

    // ETAPA 4.1: Selecionar Item Específico
    case 'selecionar_abertura':
        // 'unserialize' reconstrói o objeto Casa a partir do texto salvo na sessão
        $casa = unserialize($_SESSION['casa']); 
        $tipo = $_POST['tipo'] ?? '';

        // Decide qual lista carregar (Portas ou Janelas)
        $lista = ($tipo === 'porta') ? $casa->getListaDePortas() : $casa->getListaDeJanelas();

        if (empty($lista)) {
            echo "<h2>Nenhuma $tipo cadastrada!</h2>";
            echo '<a href="../view/index.html">Voltar ao menu</a>';
            exit;
        }

        echo "<h2>Selecionar qual " . ($tipo === 'porta' ? "Porta" : "Janela") . " deseja movimentar:</h2>";
        echo '<form action="processa.php" method="POST">';
        echo '<input type="hidden" name="acao" value="mover_abertura">';
        echo "<input type='hidden' name='tipo' value='$tipo'>";
        
        // Cria um <select> com todas as opções disponíveis
        echo "<select name='posicao'>";
        foreach ($lista as $i => $abertura) {
            echo "<option value='$i'> " . $abertura->getDescricao() . " (" . $abertura->getEstadoTexto() . ")</option>";
        }
        echo "</select><br><br>";
        echo '<button type="submit">Avançar</button>';
        echo '</form>';
        echo '<br><a href="../view/index.html">Voltar ao menu</a>';
        break;

    // ETAPA 4.2: Definir novo estado
    case 'mover_abertura':
        $casa = unserialize($_SESSION['casa']);
        $tipo = $_POST['tipo'] ?? '';
        $posicao = (int)($_POST['posicao'] ?? -1);
        
        // Busca o objeto específico usando o método da classe Casa
        $abertura = $casa->retornaAbertura($tipo, $posicao);

        if (!$abertura) {
            echo "<h2>Erro: Abertura inválida.</h2>";
            echo '<a href="../view/index.html">Voltar</a>';
            exit;
        }

        echo "<h2>Movendo: " . $abertura->getDescricao() . "</h2>";
        echo "<p>Estado atual: <strong>" . $abertura->getEstadoTexto() . "</strong></p>";

        echo '<form action="processa.php" method="POST">';
        echo '<input type="hidden" name="acao" value="aplicar_movimento">';
        echo "<input type='hidden' name='tipo' value='$tipo'>";
        echo "<input type='hidden' name='posicao' value='$posicao'>";
        echo "<label>Novo estado:</label><br>";
        echo "<select name='novo_estado'>
                <option value='1'>Aberta</option>
                <option value='0'>Fechada</option>
              </select><br><br>";
        echo '<button type="submit">Aplicar</button>';
        echo '</form>';
        break;

    // ETAPA 4.3: Aplicar Movimento e Salvar
    case 'aplicar_movimento':
        $casa = unserialize($_SESSION['casa']);
        $tipo = $_POST['tipo'] ?? '';
        $posicao = (int)($_POST['posicao'] ?? -1);
        $novoEstado = (int)($_POST['novo_estado'] ?? 0);
        
        $abertura = $casa->retornaAbertura($tipo, $posicao);

        if ($abertura) {
            // Aplica a alteração no objeto
            $casa->moverAbertura($abertura, $novoEstado);
            
            // IMPORTANTE: Atualiza o objeto na sessão
            // Como alteramos o objeto na memória, precisamos serializar e salvar
            // novamente na sessão, senão a mudança será perdida na próxima página.
            $_SESSION['casa'] = serialize($casa);
            
            echo "<h2>" . ucfirst($tipo) . " movimentada com sucesso!</h2>";
            echo "<p><strong>" . $abertura->getDescricao() . "</strong> agora está <strong>" . $abertura->getEstadoTexto() . "</strong>.</p>";
        } else {
            echo "<h2>Erro ao movimentar abertura.</h2>";
        }
        echo '<br><a href="../view/index.html">Voltar ao menu</a>';
        break;

    // ETAPA 5: Ver Informações
    case 'ver_info':
        if (!isset($_SESSION['casa'])) {
            echo "<h2>Nenhuma casa foi construída ainda!</h2>";
            echo '<a href="../view/index.html">Voltar ao menu</a>';
            break;
        }
        // Recupera e exibe
        $casa = unserialize($_SESSION['casa']);
        echo $casa->geraInfoCasa(); 
        
        echo '<br><br>';
        echo '<form action="processa.php" method="POST">
                <button type="submit" name="acao" value="limpar_sessao">Limpar Sessão / Nova Construção</button>
              </form>';
        echo '<br><a href="../view/index.html">Voltar ao menu</a>';
        break;

    // Limpar Sessão
    case 'limpar_sessao':
        session_unset(); // Remove todas as variáveis da sessão
        session_destroy(); // Destrói a sessão no servidor
        echo "<h2>Dados da casa apagados!</h2>";
        echo "<p>Você pode construir uma nova casa agora.</p>";
        echo '<a href="../view/index.html">Voltar ao menu inicial</a>';
        break;

    default:
        echo "<h2>Ação inválida.</h2>";
        echo '<a href="../view/index.html">Voltar ao menu</a>';
        break;
}
echo '
</body>
</html>
';

?>