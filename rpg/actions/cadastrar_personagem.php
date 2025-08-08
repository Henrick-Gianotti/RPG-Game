<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';
require_once 'controllers/CadastroController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_usuario = $_POST['nome_usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    $controller = new CadastroController($pdo);
    $resultado = $controller->registrar($nome_usuario, $senha, $confirmar_senha);

    if (strlen($resultado) > 16) { 
        $_SESSION['erro_cadastro'] = $resultado;
        header("Location: " . BASE_URL . "/cadastro");
        exit();
    } else {
        $_SESSION['cadastro_sucesso'] = true;
        $_SESSION['codigo_recuperacao'] = $resultado;
        header("Location: " . BASE_URL . "/cadastro");
        exit();
    }
}