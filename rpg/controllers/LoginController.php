<?php
class LoginController {
    
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function tryLogin(string $nome_usuario, string $senha)
    {
        if (empty($nome_usuario) || empty($senha))
        {
            return false;
        }

        try 
        {
            $sql = "SELECT id, nome_usuario, senha FROM usuario WHERE nome_usuario = :nome_usuario LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nome_usuario', $nome_usuario, PDO::PARAM_STR);
            $stmt->execute();

            $usuario = $stmt->fetch();

            if ($usuario && password_verify($senha, $usuario['senha']))
            {
                return
                [
                    'id' => $usuario['id'],
                    'nome' => $usuario['nome_usuario']
                ];
            }
            return false;

        } catch (PDOException $e)
        {
            error_log("Erro no login: " . $e->getMessage());
            return false;
        }
    }
}
?>