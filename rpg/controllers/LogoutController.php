<?php

class LogoutController {

    /* Limpa as variáveis de sessão, destrói a sessão e redireciona para a página de login. */
    public function logout()
    {
        // Limpa todas as variáveis da sessão.
        $_SESSION = array();

        // Garante que o cookie da sessão seja deletado também.
        if (ini_get("session.use_cookies"))
        {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header("Location: " . BASE_URL . "/login");
        exit();
    }
}