document.addEventListener('DOMContentLoaded', () =>{
    const modal = document.getElementById('delete-person-modal');
    const cancelBtn = document.getElementById('cancel-delete-btn');
    const confirmBtn = document.getElementById('confirm-delete-btn');
    const deleteTriggerBtns = document.querySelectorAll('.btn-deletar');

    let formToSubmit = null;

    const openModal = (form) =>{
        formToSubmit = form;
        modal.classList.remove('hidden');
    };

    const closeModal = () =>{
        formToSubmit = null;
        modal.classList.add('hidden');
    };

    deleteTriggerBtns.forEach(button => {
        button.addEventListener('click', (event) =>{
            const form = event.target.closest('.form-deletar-personagem');
            openModal(form);
        });
    });

    confirmBtn.addEventListener('click', () =>{
        if (formToSubmit)
        {
            formToSubmit.submit();
        }
    });

    cancelBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (event) =>{
        if (event.target === modal)
        {
            closeModal();
        }
    });
});