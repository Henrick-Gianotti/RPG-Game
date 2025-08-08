<?php
require_once 'config/database.php';
require_once 'controllers/DeleteUserController.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION['id_usuario']))
{
    header("Location: " . BASE_URL . "/selecionar_personagem");
    exit();
}

$id_usuario_para_deletar = $_SESSION['id_usuario'];

$controller = new DeleteUsuarioController($pdo);
$controller->deletar($id_usuario_para_deletar);