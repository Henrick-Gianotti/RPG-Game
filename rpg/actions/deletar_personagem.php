<?php
require_once 'config/database.php';
require_once 'controllers/PersonagemController.php';

$char_id_para_deletar = (int)$_POST['char_id'];
$id_usuario_logado = $_SESSION['id_usuario'];

$personagemController = new PersonagemController($pdo);
$personagemController->deletarPersonagem($char_id_para_deletar, $id_usuario_logado);

header("Location: " . BASE_URL . "/selecao_personagem");
exit();