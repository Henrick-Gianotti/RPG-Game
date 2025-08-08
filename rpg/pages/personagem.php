<?php
$css_pagina_especifica = 'css/personagem.css';
include_once("templates/header.php");
require_once 'config/database.php';
require_once 'controllers/PersonagemController.php';

$personagemController = new PersonagemController($pdo);
$id_usuario = $_SESSION['id_usuario'] ?? 0;

if (isset($matches[1]))
{
    // Se a rota continha um nome (ex: /personagem/nome_personagem), $matches[1] terá "nome_personagem"
    // O urldecode é usado para reverter caracteres especiais (volta os espaços removidos, ex: abc -> a b c)
    $nome_personagem_url = urldecode(trim($matches[1]));
    $troca_sucesso = $personagemController->trocarPersonagemAtivoPorNome($nome_personagem_url, $id_usuario);

    if (!$troca_sucesso)
    {
        // Se a troca falhar (personagem não existe ou não é do usuário) e já redireciona para a tela de seleção para evitar acesso indevido.
        header("Location: " . BASE_URL . "/selecao_personagem");
        exit();
    }

} else if (!isset($_SESSION['personagem_id']))
{
    // Se nenhum nome foi passado na URL e nenhum personagem está ativo na sessão, volta pra seleção de personagem
    header("Location: " . BASE_URL . "/selecao_personagem");
    exit();
}

//pega o ID do personagem
$personagem_id_ativo = $_SESSION['personagem_id'];
$personagem = $personagemController->buscarPorId($personagem_id_ativo);

if (!$personagem)
{
    unset($_SESSION['personagem_id']);
    header("Location: " . BASE_URL . "/selecao_personagem");
    exit();
}


?>

<main class="conteudo-principal">
    <h1>Ficha de <?php echo htmlspecialchars($personagem['nome']); ?></h1>

    <table class="tabela-info">
        <tbody>
            <tr>
                <td>Nome:</td>
                <td><?php echo htmlspecialchars($personagem['nome']); ?></td>
            </tr>
            <tr>
                <td>Classe:</td>
                <td><?php echo htmlspecialchars($personagem['classe']); ?></td>
            </tr>
            <tr>
                <td>Nível:</td>
                <td><?php echo $personagem['nivel']; ?></td>
            </tr>
            <tr>
                <td>Vida (HP):</td>
                <td><?php echo round($personagem['hp_atual']); ?> / <?php echo round($personagem['hp_maximo']); ?></td>
            </tr>
            <tr>
                <td>Mana (MP):</td>
                <td><?php echo round($personagem['mp_atual']); ?> / <?php echo round($personagem['mp_maximo']); ?></td>
            </tr>
            <tr>
                <td>Ouro:</td>
                <td><?php echo round($personagem['gold']); ?></td>
            </tr>
        </tbody>
    </table>
</main>
<?php
require_once 'templates/footer.php';
?>