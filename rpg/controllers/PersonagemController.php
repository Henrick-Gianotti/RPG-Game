<?php
class PersonagemController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function trocarPersonagemAtivoPorNome(string $nome_personagem, int $id_usuario): bool
    {
        // Esta query faz a busca e a verificação de dono de uma só vez
        $sql = "SELECT id FROM personagem WHERE nome = :nome AND id_usuario = :id_usuario LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nome' => $nome_personagem, ':id_usuario' => $id_usuario]);
        
        $personagem = $stmt->fetch();

        if ($personagem)
        {
            // Personagem encontrado e pertence ao usuário
            $_SESSION['personagem_id'] = $personagem['id'];
            return true;
        }

        // Se não encontrou o personagem não existe ou não pertence ao usuário
        return false;
    }

    public function buscarPorId(int $personagem_id)
    {
        $sql = "SELECT * FROM personagem WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $personagem_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletarPersonagem(int $personagem_id, int $id_usuario): bool
    {
        try
        {
            $sql = "DELETE FROM personagem WHERE id = :personagem_id AND id_usuario = :id_usuario";
            
            $stmt = $this->pdo->prepare($sql);
            
            $stmt->execute([
                ':personagem_id' => $personagem_id,
                ':id_usuario'    => $id_usuario
            ]);

            // rowCount() retorna o número de linhas afetadasm, se for > 0, significa que o personagem foi deletado com sucesso.
            return $stmt->rowCount() > 0;

        } catch (PDOException $e)
        {
            error_log("Erro ao deletar personagem: " . $e->getMessage());
            return false;
        }
    }
}