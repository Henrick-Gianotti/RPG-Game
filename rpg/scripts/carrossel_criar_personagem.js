document.addEventListener('DOMContentLoaded', function() {

    const track = document.querySelector('.carrossel-track');
    const slides = Array.from(track.children);
    const nextButton = document.getElementById('nextBtn');
    const prevButton = document.getElementById('prevBtn');

    if (track && nextButton && prevButton && slides.length > 0) {
        const itemsToShow = 3;

        if (slides.length <= itemsToShow) {
            nextButton.style.display = 'none';
            prevButton.style.display = 'none';
        } else {
            const slideStyle = getComputedStyle(slides[0]);
            const slideMargin = parseFloat(slideStyle.marginLeft) + parseFloat(slideStyle.marginRight);
            const slideWidth = slides[0].offsetWidth + slideMargin;
            let currentIndex = 0;

            const moveToSlide = (targetIndex) => {
                track.style.transform = 'translateX(-' + slideWidth * targetIndex + 'px)';
                currentIndex = targetIndex;
            };

            nextButton.addEventListener('click', () => {
                let nextIndex = currentIndex + 1;
                if (nextIndex > slides.length - itemsToShow) {
                    nextIndex = 0;
                }
                moveToSlide(nextIndex);
            });

            prevButton.addEventListener('click', () => {
                let prevIndex = currentIndex - 1;
                if (prevIndex < 0) {
                    prevIndex = slides.length - itemsToShow;
                }
                moveToSlide(prevIndex);
            });
            
            moveToSlide(0);
        }
    }

    const classCards = document.querySelectorAll('.class-card');
    const escolherBtns = document.querySelectorAll('.btn-escolher');
    const hiddenInput = document.getElementById('classe-selecionada-input');

    if (classCards.length > 0 && escolherBtns.length > 0 && hiddenInput) {
        escolherBtns.forEach(button => {
            button.addEventListener('click', function() {
                const selectedCard = this.closest('.class-card');
                const selectedClass = selectedCard.dataset.id;
                
                classCards.forEach(card => card.classList.remove('selecionado'));
                escolherBtns.forEach(btn => {
                    btn.classList.remove('selecionado');
                    btn.textContent = 'Escolher';
                });

                selectedCard.classList.add('selecionado');
                this.classList.add('selecionado');
                this.textContent = 'Selecionado';
                hiddenInput.value = selectedClass;
            });
        });
    }


    const creationForm = document.querySelector('form');
    const nameInput = document.getElementById('nome');
    const errorContainer = document.getElementById('creation-error');

    if (creationForm && nameInput && errorContainer && hiddenInput) {
        creationForm.addEventListener('submit', function(event) {
            errorContainer.textContent = '';

            // 1. Valida se uma classe foi selecionada
            if (hiddenInput.value === '') {
                event.preventDefault(); // Impede o envio do formulário
                errorContainer.textContent = 'Por favor, selecione uma classe';
                return;
            }

            // 2. Valida se o nome foi preenchido
            if (nameInput.value.trim() === '') {
                event.preventDefault(); // Impede o envio do formulário
                errorContainer.textContent = 'Por favor, insira o nome do seu personagem';
                return;
            }
        });
    }
});