<?php
class CadastroController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function registrar(string $nome_usuario, string $senha, string $confirmar_senha)
    {
        if (empty($nome_usuario) || empty($senha) || empty($confirmar_senha))
        {
            return "Por favor, preencha todos os campos.";
        }
        if (strlen($nome_usuario) < 2)
        {
            return "O nome de usuário deve ter pelo menos 2 caracteres.";
        }
        if ($senha !== $confirmar_senha)
        {
            return "As senhas digitadas não coincidem.";
        }
        if (strlen($senha) < 4)
        {
            return "A senha deve ter pelo menos 4 caracteres.";
        }

        try
        {
            $sql_check = "SELECT id FROM usuario WHERE nome_usuario = :nome_usuario";
            $stmt_check = $this->pdo->prepare($sql_check);
            $stmt_check->execute([':nome_usuario' => $nome_usuario]);
            if ($stmt_check->fetch()) {
                return "Este nome de usuário já está cadastrado.";
            }

            $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
            $codigo_recuperacao = bin2hex(random_bytes(8));

            $sql_insert = "INSERT INTO usuario (nome_usuario, senha, codigo_recuperacao) VALUES (:nome_usuario, :senha, :codigo_recuperacao)";
            $stmt_insert = $this->pdo->prepare($sql_insert);
            $stmt_insert->execute([
                ':nome_usuario' => $nome_usuario,
                ':senha' => $hash_senha,
                ':codigo_recuperacao' => $codigo_recuperacao
            ]);

            return $codigo_recuperacao;

        } catch (PDOException $e)
        {
            error_log("Erro no cadastro: " . $e->getMessage());
            return "Ocorreu um erro inesperado ao tentar criar a conta.";
        }
    }
}