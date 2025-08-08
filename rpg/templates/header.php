<?php
if (!isset($_SESSION['id_usuario']))
{    
    header("Location: " . BASE_URL . "/login");
    exit();
}

$array_js = []; //Criando array para guardar o caminho dos scripts.js 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG</title>
    <link rel="stylesheet" href="/rpg/css/header.css">
    <link rel="stylesheet" href="/rpg/css/menu_aside.css">
    <?php
        if (isset($css_pagina_especifica))
        {
            echo '<link rel="stylesheet" href="/rpg/' . $css_pagina_especifica . '">';
        }
    ?>
</head>
<body>
    <?php
    include_once("templates/menu_aside.php")
    ?>
    <div class="header-trigger-area">
        <header class="main-header">
            <div class="header-logo">
                <h3>RPG</h3>
            </div>
            <div class="hamburger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </header>
    </div>

<div id="delete-user-modal" class="modal-overlay hidden">
    <div class="modal-content">
        <h2 style="color: #c0392b;">Atenção! Você quer mesmo deletar sua conta?</h2>
        <p>Você tem certeza que deseja continuar?</p>
        <div class="modal-actions">
            <button type="button" id="cancel-delete-user-btn" class="btn-cancelar">Vish, mudei de ideia</button>
            <button type="button" id="confirm-delete-user-btn" class="btn-confirmar-exclusao">Sim, quero apagar minha conta!</button>
        </div>
    </div>
</div>