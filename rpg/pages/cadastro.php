<?php
    $erro = '';
    $mostrar_modal_sucesso = false;
    $codigo_recuperacao_para_modal = '';

    // mensagem de erro da action, nao sei se realmente funciona
    if (isset($_SESSION['erro_cadastro']))
    {
        $erro = $_SESSION['erro_cadastro'];
        unset($_SESSION['erro_cadastro']);
    }


    if (isset($_SESSION['cadastro_sucesso']) && isset($_SESSION['codigo_recuperacao']))
    {
        $mostrar_modal_sucesso = true;
        $codigo_recuperacao_para_modal = $_SESSION['codigo_recuperacao'];
        
        unset($_SESSION['cadastro_sucesso']);
        unset($_SESSION['codigo_recuperacao']);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body class="body-cadastro">

    <div class="cadastro-container">
        <h1>Crie uma conta para salvar seus personagens</h1>
        <?php if (!empty($erro)): ?>
            <div class="mensagem-erro"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/cadastrar_personagem" method="POST">
            <div class="input-group">
                <label for="nome_usuario">Nome de Usuário</label>
                <input type="text" id="nome_usuario" name="nome_usuario" required>
            </div>
            
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <div class="input-group">
                <label for="confirmar_senha">Confirmar Senha</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" required>
            </div>
            
            <button type="submit" class="btn-auth">Cadastrar</button>
        </form>
        
        <div class="links-adicionais">
            <a href="<?php echo BASE_URL; ?>/login">Já tem uma conta? Entrar</a>
        </div>
    </div>

    <div id="modal-cadastro" class="modal-overlay hidden">
        <div class="modal-content">
            <h2 style="color: #2ecc71;">Cadastrado com Sucesso!</h2>
            <p>Guarde bem o seu código de recuperação. Ele é a única forma de recuperar sua conta.</p>
            <div class="recovery-code-box">
                <strong id="display-codigo-recuperacao"></strong>
            </div>
            <div class="modal-actions">
                <button type="button" id="btn-anote-codigo" class="btn-auth">Anotei o código</button>
            </div>
        </div>
    </div>

</body>
</html>
<?php
if ($mostrar_modal_sucesso):
?>
<script>
        // Por conter código php, não dá para criar um arquivo.js separado
        // Erro encontrado para não esquecer: tudo que estiver dentro da sintaxe php não vai ser lido se não for arquivo php (tipo o BASE_URL)

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modal-cadastro');
            const codeDisplay = document.getElementById('display-codigo-recuperacao');
            const anoteiBtn = document.getElementById('btn-anote-codigo');
            const recoveryCode = "<?php echo $codigo_recuperacao_para_modal; ?>";

            if(modal && codeDisplay && anoteiBtn) {
                codeDisplay.textContent = recoveryCode;
                modal.classList.remove('hidden');

                anoteiBtn.addEventListener('click', function() {
                    window.location.href = "<?php echo BASE_URL; ?>/selecao_personagem";
                });
            }
        });
</script>
<?php
endif;
?>
</body>
</html>