<?php
    $css_pagina_especifica = 'css/selecao_personagem.css';
    require 'templates/header.php';
    require_once 'config/database.php';
    array_push($array_js, '/scripts/model_deletar_personagem.js');//array_js criado no header
    
    $id_usuario = $_SESSION['id_usuario'] ?? 0;

    $sql = "SELECT id, nome, classe, nivel FROM personagem WHERE id_usuario = :id_usuario ORDER BY id ASC LIMIT 3";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_usuario' => $id_usuario]);
    $personagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="conteudo-principal">
    <h1>Escolha seu Personagem</h1>
    <p style="text-align: center; margin-top: -15px; margin-bottom: 30px;">Você está logado como: <strong><?php echo htmlspecialchars($_SESSION['nome_usuario']); ?></strong></p>

    <div class="selecao-container">

<?php
    // Loop para criar os 3 slots de personagem
    for ($i = 0; $i < 3; $i++)
    {
    
        // Verifica se existe um personagem para o slot atual
        if (isset($personagens[$i]))
        {
            $personagem = $personagens[$i];
            // Se existe mostra o card do personagem existente
            ?>
            <div class="slot slot-personagem-existente">
                <div class="personagem-retrato"></div>
                <div class="personagem-info">
                    <h2><?php echo htmlspecialchars($personagem['nome']); ?></h2>
                    <p><?php echo htmlspecialchars($personagem['classe']); ?>, Nível <?php echo $personagem['nivel']; ?></p>
                </div>
                <form action="<?php echo BASE_URL; ?>/selecionar_personagem" method="POST" style="margin-top: auto;">
                    <input type="hidden" name="id_personagem" value="<?php echo $personagem['id']; ?>">
                    <button type="submit" class="btn-selecionar">Jogar com este</button>
                </form>

                <form action="<?php echo BASE_URL; ?>/deletar_personagem" method="POST" class="form-deletar-personagem">
                <input type="hidden" name="char_id" value="<?php echo $personagem['id']; ?>">
                <button type="button" class="btn-deletar">Apagar</button>
            </form>
            </div>
            <?php
        } else
        {
                    // Se não existe mostra um card vazio para criar um novo personagem
            ?>
                    <a href="<?php echo BASE_URL; ?>/criar_personagem" class="slot slot-personagem-vazio">
                        <div class="icone-criar"></div>
                        <span>Criar Novo Personagem</span>
                    </a>
            <?php
        }
    }
?>
    </div>
</main>
<div id="delete-person-modal" class="modal-overlay hidden">
    <div class="modal-content">
        <h2>Confirmar Exclusão</h2>
        <p>Você tem certeza que deseja apagar este personagem?<br></p>
        <div class="modal-actions">
            <button type="button" id="cancel-delete-btn" class="btn-cancelar">Cancelar</button>
            <button type="button" id="confirm-delete-btn" class="btn-confirmar-exclusao">Sim, Apagar</button>
        </div>
    </div>
</div>
<?php
require_once 'templates/footer.php';
?>