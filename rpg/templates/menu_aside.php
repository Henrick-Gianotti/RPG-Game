<aside class="barra-lateral">
    <h2>RPG</h2>
    <nav>
        <ul>
            <li><a href="personagem">Ficha do Personagem</a></li>
            <li><a href="combate">Área de Combate</a></li>
            <li><a href="floresta">Floresta</a></li>
            <li><a href="mineracao">Mina de Ouro</a></li>
            <li><a href="criar_personagem">criar personagem (apagar)</a></li>
            <li><a href="selecao_personagem">Selecionar personagem (apagar)</a></li>
        </ul>
        <ul class="delete-section">
            <li>
            <button type="button" class="delete-user-button js-load-script" data-script="scripts/model_deletar_usuario.js" data-callback="initDeleteUserModal">Deletar conta</button>
            <form action="<?php echo BASE_URL; ?>/deletar_usuario" method="POST" id="delete-user-form" style="display: none;"></form>
            </li>
        </ul>
        </ul>
        <ul class="logout-section">
            <li><a href="<?php echo BASE_URL; ?>/logout" class="logout-button">Sair (Logout)</a></li>
        </ul>
    </nav>
</aside>

