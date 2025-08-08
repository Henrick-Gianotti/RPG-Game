<?php
class DeleteUsuarioController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function deletar(int $id_usuario)
    {
        // Garante que um ID válido foi passado
        if ($id_usuario <= 0) {
            // Se não, apenas redireciona para o login por segurança
            header("Location: " . BASE_URL . "/login");
            exit();
        }

        try {
            // Apaga o usuário do banco.
            $sql = "DELETE FROM usuario WHERE id = :id_usuario";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_usuario' => $id_usuario]);

            // Após apagar faz o logout
            $_SESSION = array();

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            session_destroy();

            // Redireciona para a página inicial com tudo limpo
            header("Location: " . BASE_URL . "/login"); // deixei no login pois nao tenho pagina inicial ainda
            exit();

        } catch (PDOException $e) {
            error_log("Erro ao deletar usuário: " . $e->getMessage());
            // Em caso de erro, apenas desloga o usuário por segurança
            header("Location: " . BASE_URL . "/logout");
            exit();
        }
    }
}