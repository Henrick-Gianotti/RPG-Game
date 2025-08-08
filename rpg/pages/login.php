<?php
if (isset($_SESSION['id_usuario'])) {
    header("Location: " . BASE_URL . "/selecao_personagem");
    exit();
}

require_once 'config/database.php';
require_once 'controllers/LoginController.php';

$erro_login = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $nome_usuario = trim($_POST['nome_usuario']);
    $senha = $_POST['senha'];

    $loginController = new LoginController($pdo);
    $usuario_logado = $loginController->tryLogin($nome_usuario, $senha);

    if ($usuario_logado) {
        session_regenerate_id(true);
        $_SESSION['id_usuario'] = $usuario_logado['id'];
        $_SESSION['nome_usuario'] = $usuario_logado['nome'];
        
        header("Location: " . BASE_URL . "/selecao_personagem");
        exit();
    } else
    {
        $erro_login = "Nome de usuário ou senha inválidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body class="body-login">

    <div class="login-container">
        <h1>Acessar o Jogo</h1>

        <?php
        if (!empty($erro_login)) {
            echo '<div class="mensagem-erro">' . htmlspecialchars($erro_login) . '</div>';
        }
        ?>
        
        <form action="<?php echo BASE_URL; ?>/login" method="POST">
            <div class="input-group">
                <label for="nome">Usuário</label>
                <input type="text" id="nome_usuario" name="nome_usuario" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn-login">Entrar</button>
        </form>
        <div class="links-adicionais">
            <a href="cadastro">Esqueceu a senha?</a>
            <a href="cadastro">Criar uma conta</a>
        </div>
    </div>
</body>
</html>