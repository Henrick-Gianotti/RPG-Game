    // Este script só será impresso na página se o cadastro tiver sido bem-sucedido
    document.addEventListener('DOMContentLoaded', function() {
        // Seleciona os elementos do modal
        const modal = document.getElementById('modal-cadastro');
        const codeDisplay = document.getElementById('display-codigo-recuperacao');
        const anoteiBtn = document.getElementById('btn-anote-codigo');

        // Pega o código de recuperação que o PHP guardou na sessão
        const recoveryCode = "<?php echo $_SESSION['codigo_recuperacao']; ?>";

        // Coloca o código no modal e o exibe
        codeDisplay.textContent = recoveryCode;
        modal.classList.remove('hidden');

        anoteiBtn.addEventListener('click', function() {
            window.location.href = "<?php echo BASE_URL; ?>/selecao_personagem";
        });
    });