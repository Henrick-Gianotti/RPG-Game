<?php
    $css_pagina_especifica = 'css/home.css';
    include_once("templates/header.php");
?>

<main class="conteudo-principal">
    <div class="home-container">
        <h1>Bem-vindo, aventureiro!</h1>
        <p>Escolha seu destino ou acesse sua ficha de personagem na barra lateral.</p>
        <div class="home-atalhos">
            <a href="combate" class="btn-atalho">Ir para Combate</a>
            <a href="floresta" class="btn-atalho">Explorar Floresta</a>
            <a href="mineracao" class="btn-atalho">Visitar a Mina de Ouro</a>
        </div>
    </div>
</main>
<?php
require_once 'templates/footer.php';
?>