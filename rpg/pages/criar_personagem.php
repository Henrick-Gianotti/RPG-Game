<?php
    $css_pagina_especifica = 'css/criar_personagem.css';

    include_once("templates/header.php");
    require_once 'config/database.php';
    require_once 'controllers/CriarPersonagemController.php';
    
    array_push($array_js, "scripts/carrossel_criar_personagem.js");
    $erro = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Pega os dados do formulário usando os nomes corretos
        $nome_personagem = trim($_POST['nome'] ?? '');
        $classe_id = (int)($_POST['classe_id'] ?? 0);
        $id_usuario = $_SESSION['id_usuario'] ?? 0;

        // Instancia o controller e tenta criar o personagem
        $controller = new CriarPersonagemController($pdo);
        $resultado = $controller->criar($id_usuario, $nome_personagem, $classe_id);

        if ($resultado === true) {
            header("Location: " . BASE_URL . "/selecionar_personagem");
            exit();
        } else {
            $erro = $resultado;
        }
    }
?>


<form id="form-criar-personagem" method="POST" action="<?php echo BASE_URL; ?>/criar_personagem">
<main class="conteudo-principal">
    <h1>Criação de Personagem</h1>
    <p style="text-align: center; margin-top: -20px; margin-bottom: 30px; color: #bdc3c7;">Escolha a classe que define seu estilo de jogo.</p>

    <div class="carrossel-container">
        <button type="button" id="prevBtn" class="carrossel-btn prev">&#10094;</button>

        <div class="carrossel-viewport">
            <div class="carrossel-track">
                
                <div class="class-card" data-classe="Guerreiro" data-id="1">
                    <h2>Guerreiro</h2>
                    <ul class="attributes-list">
                        <li class="atributo-pos">+Life</li>
                        <li class="atributo-pos">+Tank</li>
                        <li class="atributo-pos">+Versatile</li>
                    </ul>
                    <button class="btn-escolher" type="button">Escolher</button>
                </div>

                <div class="class-card" data-classe="Arqueiro" data-id="2">
                    <h2>Archer</h2>
                    <ul class="attributes-list">
                        <li class="atributo-pos">+Dodge</li>
                        <li class="atributo-pos">+Precision</li>
                        <li class="atributo-pos">+Versatile</li>
                    </ul>
                    <button class="btn-escolher" type="button">Escolher</button>
                </div>

                <div class="class-card" data-classe="Mago" data-id="3">
                    <h2>Mage</h2>
                    <ul class="attributes-list">
                        <li class="atributo-pos">+Burst Damage</li>
                        <li class="atributo-pos">+Magical Damage</li>
                        <li class="atributo-neg">-Glass Cannon</li>
                    </ul>
                    <button class="btn-escolher" type="button">Escolher</button>
                </div>

                <div class="class-card" data-classe="Assassino" data-id="4">
                    <h2>Assassin</h2>
                    <ul class="attributes-list">
                        <li class="atributo-pos">+Critical</li>
                        <li class="atributo-pos">+Dodge</li>
                        <li class="atributo-neg">-Weak</li>
                    </ul>
                    <button class="btn-escolher" type="button">Escolher</button>
                </div>
            </div>
        </div>

        <button type="button" id="nextBtn" class="carrossel-btn next">&#10095;</button>
    </div>
    <div class="finalizar-criacao">
        <label for="nome">Nome do Personagem:</label>
        <input type="text" id="nome" name="nome" placeholder="Digite o nome aqui..." required>
        <input type="hidden" id="classe-selecionada-input" name="classe_id">
        
        <p id="creation-error" class="mensagem-erro"><?php echo !empty($erro) ? htmlspecialchars($erro) : ''; ?></p>
        <button type="submit" class="btn-criar-person">Criar Personagem</button>
    </div>

</main>
</form>
<?php
require_once 'templates/footer.php';
?>