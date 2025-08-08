<?php
require_once 'config/database.php';

$usuarios_para_criar = [
    ['nome' => 'Gandalf', 'senha' => '123'],
    ['nome' => 'Legolas', 'senha' => '12345']
];

echo "Criando usuários...<br>";

try
{
    $sql = "INSERT INTO usuario (nome_usuario, senha) VALUES (:nome_usuario, :senha)";
    $stmt = $pdo->prepare($sql);

    foreach ($usuarios_para_criar as $usuario)
    {
        $nome = $usuario['nome'];
        // Criptografa a senha antes de salvar
        $hash_senha = password_hash($usuario['senha'], PASSWORD_DEFAULT);

        $stmt->bindParam(':nome_usuario', $nome);
        $stmt->bindParam(':senha', $hash_senha);
        $stmt->execute();
        
        echo "Usuário '".htmlspecialchars($nome)."' criado com sucesso!<br>";
    }

} catch (PDOException $e)
{
    if ($e->errorInfo[1] == 1062)
    {
        echo "Usuários já existem.<br>";
    } else {
        die("Erro ao criar usuários: " . $e->getMessage());
    }
}
?>