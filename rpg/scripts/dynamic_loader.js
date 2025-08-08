// Criei o dynamic loader para esconder o script de deletar a conta
function loadScript(path, callback) {
    const scriptId = 'scripts-' + path.replace(/[^a-zA-Z0-9]/g, '');

    // Verifica se já foi acionado e chama o callback
    if (document.getElementById(scriptId)) {
        if (callback) callback();
        return;
    }

    // Se não cria a tag <script>
    const script = document.createElement('script');
    script.id = scriptId;
    script.src = `${BASE_URL}/${path}`; // a BASE_URL foi definida no footer.php

    // chama o callback do form
    script.onload = () => {
        console.log(`Script ${path} carregado com sucesso.`); //debug
        if (callback) callback();
    };
    
    // adiciona o script para o download
    document.body.appendChild(script);
}


document.addEventListener('DOMContentLoaded', () =>
{
    // Instância os botões com "js-load-script"
    const triggers = document.querySelectorAll('.js-load-script');

    triggers.forEach(trigger => {
        trigger.addEventListener('click', () =>
        {
            const scriptToLoad = trigger.dataset.script;
            const callbackFunctionName = trigger.dataset.callback;
            //Verifica os botões e aciona o callback para funcionar o script
            if (scriptToLoad && callbackFunctionName)
            {
                loadScript(scriptToLoad, () =>
                {
                    if (typeof window[callbackFunctionName] === 'function')
                    {
                        window[callbackFunctionName]();
                    } else 
                    {
                        console.error(`Função de callback "${callbackFunctionName}" não encontrada após carregar ${scriptToLoad}.`);
                    }
                });
            } else
            {
                console.error("Atributos 'data-script' ou 'data-callback' faltando no botão gatilho.");//debug
            }
        });
    });
});