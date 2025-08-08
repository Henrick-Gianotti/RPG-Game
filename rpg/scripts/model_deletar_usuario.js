// Este script só é carregado quando o usuário clica em "Deletar conta"

function initDeleteUserModal() {
    const deleteForm = document.getElementById('delete-user-form');
    const modal = document.getElementById('delete-user-modal');
    const cancelBtn = document.getElementById('cancel-delete-user-btn');
    const confirmBtn = document.getElementById('confirm-delete-user-btn');

    if (!deleteForm || !modal || !cancelBtn || !confirmBtn) {
        console.error("Não foi possível inicializar o modal de exclusão. Elementos HTML faltando.");
        return;
    }

    const closeModal = () => {
        modal.classList.add('hidden');
    };

    // Abre o modal
    modal.classList.remove('hidden');

    // Listener para o botão de confirmação
    confirmBtn.addEventListener('click', () => {
        deleteForm.submit(); // Envia o formulário escondido
    });

    // Listeners para fechar o modal
    cancelBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });
}

// Expõe a função globalmente para o loader poder encontrá-la
window.initDeleteUserModal = initDeleteUserModal;